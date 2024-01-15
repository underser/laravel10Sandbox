<?php

namespace Feature\Api\V1\Customers;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Api\V1\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends ApiTestCase
{
    use RefreshDatabase;

    private readonly string $endpoint;
    private User $customer1;
    private User $customer2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer1 = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->customer2 = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->endpoint = route('api.customers.show', [$this->customer1]);
    }

    public function test_not_authorized_users_cannot_access_customer(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_authorized_users_with_any_roles_can_access_customer(): void
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
                        $json->where('id', $this->customer1->id)
                            ->where('name', $this->customer1->name)
                            ->where('email', $this->customer1->email)
                            ->where('country_code', $this->customer1->country_code)
                            ->where('phone', $this->customer1->phone)
                    )
            );
    }
}
