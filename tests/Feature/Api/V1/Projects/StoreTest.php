<?php
declare(strict_types=1);

namespace Feature\Api\V1\Projects;

use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\UserRoles;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use stdClass;
use Tests\Feature\Api\V1\ApiTestCase;

class StoreTest extends ApiTestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private ProjectStatus $projectStatus;
    private User $user;
    private User $client;
    private stdClass $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = route('api.projects.store');
        $this->projectStatus = ProjectStatus::factory()->create(['status' => 'Open']);
        $this->user = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->client = User::factory()->create()->assignRole(UserRoles::CLIENT->value);

        $this->payload = new stdClass();
        $this->payload->name = 'Api test name';
        $this->payload->description = 'Some gen. desc';
        $this->payload->image = UploadedFile::fake()->image('project.png');
        $this->payload->assigned_to = $this->user->id;
        $this->payload->client = $this->client->id;
        $this->payload->project_status = $this->projectStatus->status;
        $this->payload->deadline = '09/22/2024';
    }

    public function test_only_authorized_users_can_store_project(): void
    {
        $this->postJson($this->endpoint, (array)$this->payload)
            ->assertUnauthorized();
    }

    public function test_users_with_user_role_cannot_store_project(): void
    {
        $userToken = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value)
            ->createToken('userToken')
            ->plainTextToken;

        $this->postJson($this->endpoint, (array)$this->payload, $this->getAuthorizationHeader($userToken))
            ->assertForbidden();
    }

    public function test_users_with_client_role_can_store_project(): void
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
        $this->payload->name = '';
        $this->payload->description = '';
        $this->payload->image = UploadedFile::fake()->image('project.jpg')->size(3000);
        $this->payload->assigned_to = $this->client->id;
        $this->payload->client = $this->user->id;
        $this->payload->project_status = 'In Progress';
        $this->payload->deadline = '22/09/2023';

        $this->postJson($this->endpoint, (array)$this->payload, $this->adminAuthHeader)
            ->assertJson(fn(AssertableJson $json) =>
                $json->where('message', 'The name field is required. (and 6 more errors)')
                    ->has('errors', 7)
                    ->where('errors.name.0', 'The name field is required.')
                    ->where('errors.description.0', 'The description field must be a string.')
                    ->where('errors.image.0', 'The image field must not be greater than 2048 kilobytes.')
                    ->where('errors.assigned_to.0', 'User you are assigning to does not have an appropriate role.')
                    ->where('errors.client.0', 'Client does not have an appropriate role.')
                    ->where('errors.project_status.0', 'The selected project status is invalid.')
                    ->where('errors.deadline.0', 'The deadline field must match the format m/d/Y.')
            );
    }

    public function test_project_store_endpoint(): void
    {
        $this->postJson($this->endpoint, (array)$this->payload, $this->adminAuthHeader)
            ->assertJson(fn(AssertableJson $json) =>
                $json->has('data', fn(AssertableJson $json) =>
                    $json->has('id')
                        ->where('name', $this->payload->name)
                        ->where('description', $this->payload->description)
                        ->where('assigned_to', $this->user->name)
                        ->where('client', $this->client->name)
                        ->where('project_status', $this->payload->project_status)
                        ->where('deadline', $this->payload->deadline)
                        ->has('tasks', 0)
                )
            );
        $this->assertDatabaseHas('projects', [
            'title' => $this->payload->name,
            'description' => $this->payload->description,
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'project_status_id' => $this->projectStatus->id,
            'deadline' => (new Carbon($this->payload->deadline))->format('Y-m-d H:i:s')
        ]);
        $this->assertDatabaseCount('projects', 1);
    }
}
