<?php

namespace Feature\Api\V1\Projects;

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

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = route('api.projects.index');

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

        $taskStatus = TaskStatus::factory()->create(['status' => 'Open']);
        Task::factory()->create([
            'project_id' => $this->project1->id,
            'task_status_id' => $taskStatus->id
        ]);
        Task::factory()->create([
            'project_id' => $this->project2->id,
            'task_status_id' => $taskStatus->id
        ]);
    }

    public function test_not_authorized_users_cannot_access_project_list(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_authorized_users_with_any_roles_can_access_project_list(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('clientToken')
            ->plainTextToken;
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('clientToken')
            ->plainTextToken;

        foreach ([$clientToken, $userToken, $projectManagerToken] as $token) {
            $this->getJson($this->endpoint, $this->getAuthorizationHeader($token))->assertOk();
        }
    }

    public function test_projects_list_return_correct_paginated_data(): void
    {
        Project::factory(4)->create([
            'user_id' => User::factory()->create(),
            'client_id' => User::factory()->create(),
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
        ]);

        $this->getJson($this->endpoint, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['data', 'links', 'meta'])
                    ->where('meta.total', 6)
                    ->has('data', 5)
                    ->has('data.0', fn (AssertableJson $json) =>
                        $json->where('id', $this->project1->id)
                            ->where('name', $this->project1->title)
                            ->where('description', $this->project1->description)
                            ->where('assigned_to', $this->project1->user->name)
                            ->where('client', $this->project1->client->name)
                            ->where('project_status', $this->project1->status->status)
                            ->where('deadline', $this->project1->deadline->format('m/d/Y'))
                            ->has('tasks', 1)
                    )
                    ->has('data.1', fn (AssertableJson $json) =>
                        $json->where('id', $this->project2->id)
                            ->where('name', $this->project2->title)
                            ->where('description', $this->project2->description)
                            ->where('assigned_to', $this->project2->user->name)
                            ->where('client', $this->project2->client->name)
                            ->where('project_status', $this->project2->status->status)
                            ->where('deadline', $this->project2->deadline->format('m/d/Y'))
                            ->has('tasks', 1)
                        )
            );
    }
}
