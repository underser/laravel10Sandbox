<?php

namespace Feature\Api\V1\Clients;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\V1\ApiTestCase;

class DestroyTest extends ApiTestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private User $client1;
    private User $client2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client1 = User::factory()->create()->assignRole(UserRoles::CLIENT->value);
        $this->client2 = User::factory()->create()->assignRole(UserRoles::CLIENT->value);
        $this->endpoint = route('api.clients.destroy', [$this->client1]);
    }

    public function test_not_authorized_users_cannot_delete_client(): void
    {
        $this->deleteJson($this->endpoint)->assertUnauthorized();
        $this->deleteJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_authorized_users_with_any_roles_can_delete_client(): void
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
            $this->deleteJson($this->endpoint, headers: $this->getAuthorizationHeader($token))->assertStatus(204);

            // Restore customer and endpoint.
            $this->client1 = User::factory()->create()->assignRole(UserRoles::CLIENT->value);
            $this->endpoint = route('api.clients.destroy', [$this->client1]);
        }
    }

    /**
     * Test that user role is verified before deletion.
     *
     * @return void
     */
    public function test_clients_endpoint_delete_only_clients(): void
    {
        $user = User::factory()
            ->create()
            ->assignRole(UserRoles::USER->value);

        $this->deleteJson(route('api.clients.destroy', [$user]), headers: $this->adminAuthHeader)
            ->assertNotFound();
    }

    public function test_clients_endpoint_return_correct_data(): void
    {
        $this->deleteJson($this->endpoint, headers: $this->adminAuthHeader)
            ->assertNoContent();
    }
}
