<?php
declare(strict_types=1);

namespace Feature\Api\V1\Projects;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use stdClass;
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

        $this->endpoint = route('api.projects.destroy', [$this->project]);
    }

    public function test_only_authorized_users_can_destroy_project(): void
    {
        $this->deleteJson($this->endpoint)
            ->assertUnauthorized();
    }

    public function test_users_with_user_role_cannot_destroy_project(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($userToken))
            ->assertForbidden()
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('message', __('This action is unauthorized.'))
                    ->etc()
            );
    }

    public function test_users_with_client_role_can_destroy_project(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($clientToken))
            ->assertNoContent();
    }

    public function test_users_with_project_manager_role_can_destroy_project(): void
    {
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('project_manager_token')
            ->plainTextToken;

        $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($projectManagerToken))
            ->assertNoContent();
    }

    public function test_project_destroy_endpoint(): void
    {
        $this->deleteJson($this->endpoint, headers: $this->adminAuthHeader)
            ->assertNoContent();

        $this->assertDatabaseMissing('projects', [
            'title' => $this->project->title,
            'description' => $this->project->description,
            'user_id' => $this->project->user->id,
            'client_id' => $this->project->client->id,
            'project_status_id' => $this->project->status->id,
            'deadline' => (new Carbon($this->project->deadline))->format('Y-m-d H:i:s')
        ]);
        $this->assertDatabaseCount('projects', 0);
        $this->assertDatabaseCount('tasks', 0);
    }
}
