<?php
declare(strict_types=1);

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

class ShowTest extends ApiTestCase
{
    use RefreshDatabase;

    private Task $task;
    private string $endpoint;

    protected function setUp(): void
    {
        parent::setUp();

        $project = Project::factory()->create([
            'user_id' => User::factory()->create(),
            'client_id' => User::factory()->create(),
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
        ]);

        $this->task =  Task::factory()->create([
            'project_id' => $project,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);

        $this->endpoint = route('api.tasks.show', [$this->task]);
    }

    public function test_not_authorized_users_cannot_access_task_endpoint(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_users_with_client_role_can_access_task(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($clientToken))->assertOk();
    }

    public function test_users_with_project_manager_role_can_access_task(): void
    {
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('projectManagerToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($projectManagerToken))->assertOk();
    }

    public function test_users_with_user_role_can_access_task(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->getJson($this->endpoint, $this->getAuthorizationHeader($userToken))->assertOk();
    }

    public function test_project_endpoint_return_correct_data(): void
    {
        $this->getJson($this->endpoint, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn(AssertableJson $json) =>
                    $json->where('id', $this->task->id)
                        ->where('title', $this->task->title)
                        ->where('description', $this->task->description)
                        ->where('estimation', $this->task->estimation)
                        ->where('assigned_to', $this->task->user->name)
                        ->where('project', $this->task->project->title)
                        ->where('status', $this->task->status->status)
                )
            );
    }
}
