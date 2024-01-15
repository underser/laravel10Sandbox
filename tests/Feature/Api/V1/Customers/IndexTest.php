<?php

namespace Tests\Feature\Api\V1\Customers;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Api\V1\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends ApiTestCase
{
    use RefreshDatabase;

    private readonly string $endpoint;
    private User $customer1;
    private User $customer2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = route('api.customers.index');
        $this->customer1 = User::factory()->create()->assignRole(UserRoles::USER->value);
        $this->customer2 = User::factory()->create()->assignRole(UserRoles::USER->value);
    }

    public function test_not_authorized_users_cannot_access_customer_list(): void
    {
        $this->getJson($this->endpoint)->assertUnauthorized();
        $this->getJson(
            $this->endpoint,
            $this->getAuthorizationHeader('1|CHyi2Ijmc7SViVbITiKEBKmVENpXMvE1OdU8xJof')
        )->assertUnauthorized();
    }

    public function test_authorized_users_with_any_roles_can_access_customer_list(): void
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

    public function test_customer_list_return_correct_paginated_data(): void
    {
        User::factory(4)->create()->each(fn (User $user) => $user->assignRole(UserRoles::USER->value));
        User::factory()->create()->assignRole(UserRoles::CLIENT->value);

        $this->getJson($this->endpoint, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['data', 'links', 'meta'])
                    ->where('meta.total', 6)
                    ->has('data', 5, fn (AssertableJson $json) =>
                        $json->where('id', $this->customer1->id)
                            ->where('name', $this->customer1->name)
                            ->where('email', $this->customer1->email)
                            ->where('country_code', $this->customer1->country_code)
                            ->where('phone', $this->customer1->phone)
                    )
            );
    }
}
