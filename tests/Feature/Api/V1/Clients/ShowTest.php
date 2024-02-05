<?php

namespace Feature\Api\V1\Clients;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Api\V1\ApiTestCase;

class ShowTest extends ApiTestCase
{
    use RefreshDatabase;

    private readonly string $endpoint;
    private User $client1;
    private User $client2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client1 = User::factory()->create()->assignRole(UserRoles::CLIENT->value);
        $this->client2 = User::factory()->create()->assignRole(UserRoles::CLIENT->value);
        $this->endpoint = route('api.clients.show', [$this->client1]);

        Project::factory()->create([
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
            'user_id' => User::factory()->create(),
            'client_id' => $this->client1->id
        ]);
    }

    public function test_not_authorized_users_cannot_access_client(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_authorized_users_with_any_roles_can_access_client(): void
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

    public function test_customer_endpoint_return_correct_data(): void
    {
        $this->getJson($this->endpoint, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn (AssertableJson $json) =>
                    $json->where('id', $this->client1->id)
                        ->where('name', $this->client1->name)
                        ->where('email', $this->client1->email)
                        ->where('country_code', $this->client1->country_code)
                        ->where('phone', $this->client1->phone)
                        ->where('vat', (string)$this->client1->vat)
                        ->where('address', $this->client1->address)
                        ->has('projects', 1)
                )
            );
    }
}
