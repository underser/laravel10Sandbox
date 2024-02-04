<?php

namespace Feature\Api\V1\Tasks;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Api\V1\ApiTestCase;

class IndexTest extends ApiTestCase
{
    use RefreshDatabase;

    private readonly string $endpoint;

    private Project $project1;

    private Project $project2;

    private Task $task1;

    private Task $task2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = route('api.tasks.index');

        $this->project1 = Project::factory()->create([
            'user_id' => User::factory()->create(),
            'client_id' => User::factory()->create(),
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
        ]);

        $this->project2 = Project::factory()->create([
            'user_id' => User::factory()->create(),
            'client_id' => User::factory()->create(),
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
        ]);

        $this->task1 = Task::factory()->create([
            'project_id' => $this->project1->id,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);
        $this->task2 = Task::factory()->create([
            'project_id' => $this->project2->id,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'In Progress'])
        ]);
    }

    public function test_not_authorized_users_cannot_access_task_list(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_users_with_client_role_can_access_task_list(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($clientToken))->assertOk();
    }

    public function test_users_with_project_manager_role_can_access_task_list(): void
    {
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('projectManagerToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($projectManagerToken))->assertOk();
    }

    public function test_users_with_user_role_can_access_task_list(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($userToken))->assertOk();
    }

    public function test_tasks_list_return_correct_paginated_data(): void
    {
        Task::factory(4)->create([
            'project_id' => $this->project1->id,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);

        $this->getJson($this->endpoint, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['data', 'links', 'meta'])
                    ->where('meta.total', 6)
                    ->has('data', 5)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $this->task1->id)
                            ->where('title', $this->task1->title)
                            ->where('description', $this->task1->description)
                            ->where('estimation', $this->task1->estimation)
                            ->where('assigned_to', $this->task1->user->name)
                            ->where('project', $this->task1->project->title)
                            ->where('status', $this->task1->status->status)
                    )
                    ->has('data.1', fn (AssertableJson $json) =>
                        $json->where('id', $this->task2->id)
                            ->where('title', $this->task2->title)
                            ->where('description', $this->task2->description)
                            ->where('estimation', $this->task2->estimation)
                            ->where('assigned_to', $this->task2->user->name)
                            ->where('project', $this->task2->project->title)
                            ->where('status', $this->task2->status->status)
                    )
            );
    }

    public function test_tasks_can_be_filtered_by_id(): void
    {
        $taskStatus = TaskStatus::factory()->create(['status' => 'Open']);

        Task::factory(4)->create([
            'project_id' => $this->project1->id,
            'task_status_id' => $taskStatus
        ]);

        $lastCreatedTask = Task::factory()->create([
            'project_id' => $this->project2->id,
            'task_status_id' => $taskStatus
        ]);

        $this->getJson($this->endpoint . '/?id=' . $lastCreatedTask->id, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['data', 'links', 'meta'])
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $lastCreatedTask->id)
                            ->etc()
                    )
            );
    }

    public function test_tasks_can_be_filtered_by_title(): void
    {
        $title = 'Unique task title';

        Task::factory()->create([
            'title' => $title,
            'project_id' => $this->project2->id,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);

        $this->getJson($this->endpoint . '/?title=' . $title, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data', 'links', 'meta'])
                ->has('data', 1, fn (AssertableJson $json) =>
                $json->where('title', $title)
                    ->etc()
                )
            );
    }

    public function test_tasks_can_by_filtered_by_description(): void
    {
        $description = 'Unique task description';

        Task::factory()->create([
            'description' => $description,
            'project_id' => $this->project2->id,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);

        $this->getJson($this->endpoint . '/?description=' . $description, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['data', 'links', 'meta'])
                ->has('data', 1, fn (AssertableJson $json) =>
                $json->where('description', $description)
                    ->etc()
                )
            );
    }
}
