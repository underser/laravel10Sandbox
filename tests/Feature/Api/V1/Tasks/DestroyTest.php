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
use Tests\Feature\Api\V1\ApiTestCase;

class DestroyTest extends ApiTestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private Project $project;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->project = Project::factory()->create([
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Closed']),
            'client_id' => User::factory()->create()->assignRole(UserRoles::CLIENT->value),
            'user_id' => $user
        ]);

        $this->task = Task::factory()->recycle($user)->create([
            'project_id' => $this->project,
            'task_status_id' => TaskStatus::factory()->create(['status' => 'Open'])
        ]);

        $this->endpoint = route('api.tasks.destroy', [$this->task]);
    }

    public function test_only_authorized_users_can_destroy_task(): void
    {
        $this->deleteJson($this->endpoint)
            ->assertUnauthorized();
    }

    public function test_users_with_user_role_can_destroy_task(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($userToken))
            ->assertNoContent();
    }

    public function test_users_with_client_role_can_destroy_task(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($clientToken))
            ->assertNoContent();
    }

    public function test_users_with_project_manager_role_can_destroy_task(): void
    {
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('project_manager_token')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($projectManagerToken))
            ->assertNoContent();
    }

    public function test_task_destroy_endpoint(): void
    {
        $this->deleteJson($this->endpoint, headers: $this->adminAuthHeader)
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', [
            'title' => $this->task->title,
            'description' => $this->task->description,
            'estimation' => $this->task->estimation,
            'user_id' => $this->task->user->id,
            'project_id' => $this->task->project->id,
            'task_status_id' => $this->task->status->id
        ]);
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('tasks', 0);
    }
}
