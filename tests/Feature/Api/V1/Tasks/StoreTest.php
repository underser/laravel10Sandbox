<?php
declare(strict_types=1);

namespace Feature\Api\V1\Tasks;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use stdClass;
use Tests\Feature\Api\V1\ApiTestCase;

class StoreTest extends ApiTestCase
{
    use RefreshDatabase;

    private string $endpoint;

    private User $user;

    private stdClass $payload;

    private TaskStatus $taskStatus;
    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = route('api.tasks.store');
        $this->project = Project::factory()->create([
            'user_id' => User::factory()->create(),
            'client_id' => User::factory()->create(),
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open'])
        ]);
        $this->user = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->taskStatus = TaskStatus::factory()->create(['status' => 'In Progress']);

        $this->payload = new stdClass();
        $this->payload->title = 'Api test name';
        $this->payload->description = 'Some gen. desc';
        $this->payload->estimation = 88;
        $this->payload->image = UploadedFile::fake()->image('project.png');
        $this->payload->assigned_to = $this->user->id;
        $this->payload->project_id = $this->project->id;
        $this->payload->task_status = $this->taskStatus->status;
    }

    public function test_only_authorized_users_can_store_task(): void
    {
        $this->postJson($this->endpoint, (array)$this->payload)
            ->assertUnauthorized();
    }

    public function test_users_with_user_role_can_store_task(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->postJson($this->endpoint, (array)$this->payload, $this->getAuthorizationHeader($userToken))
            ->assertCreated();
    }

    public function test_users_with_client_role_can_store_task(): void
    {
        $clientToken = User::factory()
            ->create()
            ->assignRole(UserRoles::CLIENT->value)
            ->createToken('clientToken')
            ->plainTextToken;

        $this->postJson($this->endpoint, (array)$this->payload, $this->getAuthorizationHeader($clientToken))
            ->assertCreated();
    }

    public function test_users_with_project_manager_role_can_store_project(): void
    {
        $projectManagerToken = User::factory()
            ->create()
            ->assignRole(UserRoles::PROJECT_MANAGER->value)
            ->createToken('project_manager_token')
            ->plainTextToken;

        $this->postJson($this->endpoint, (array)$this->payload, $this->getAuthorizationHeader($projectManagerToken))
            ->assertCreated();
    }

    public function test_project_store_validation(): void
    {
        $this->payload->title = '';
        $this->payload->description = '';
        $this->payload->estimation = 'not a number';
        $this->payload->image = UploadedFile::fake()->image('project.jpg')->size(3000);
        $this->payload->assigned_to = '89797987';
        $this->payload->project_id = '97987987';
        $this->payload->task_status = 'Status not exists';


        $this->postJson($this->endpoint, (array)$this->payload, $this->adminAuthHeader)
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('message', 'The title field is required. (and 6 more errors)')
                    ->has('errors', 7)
                    ->where('errors.title.0', 'The title field is required.')
                    ->where('errors.description.0', 'The description field must be a string.')
                    ->where('errors.estimation.0', 'The estimation field must be a number.')
                    ->where('errors.image.0', 'The image field must not be greater than 2048 kilobytes.')
                    ->where('errors.assigned_to.0', 'The selected assigned to is invalid.')
                    ->where('errors.project_id.0', 'The selected project id is invalid.')
                    ->where('errors.task_status.0', 'The selected task status is invalid.')
            );
    }

    public function test_project_store_endpoint(): void
    {
        $this->postJson($this->endpoint, (array)$this->payload, $this->adminAuthHeader)
            ->assertJson(fn(AssertableJson $json) =>
                $json->has('data', fn(AssertableJson $json) =>
                    $json->has('id')
                        ->where('title', $this->payload->title)
                        ->where('description', $this->payload->description)
                        ->where('estimation', $this->payload->estimation . 'h')
                        ->where('assigned_to', $this->user->name)
                        ->where('project', $this->project->title)
                        ->where('status', $this->taskStatus->status)
                )
            );
        $this->assertDatabaseHas('tasks', [
            'title' => $this->payload->title,
            'description' => $this->payload->description,
            'estimation' => $this->payload->estimation,
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'task_status_id' => $this->taskStatus->id
        ]);
    }
}
