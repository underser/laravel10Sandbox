<?php
declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\User;
use App\Models\UserRoles;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class ApiTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected readonly array $adminAuthHeader;

    protected function setUp(): void
    {
        parent::setUp();

        DatabaseSeeder::seedRolesAndPermission();

        $adminUser = User::factory()->create();
        $adminUser->assignRole(UserRoles::ADMINISTRATOR->value);

        $this->adminAuthHeader = $this->getAuthorizationHeader($adminUser->createToken('primary')->plainTextToken);
    }

    protected function getAuthorizationHeader(string $token): array
    {
        return ['Authorization' => 'Bearer ' . $token];
    }
}
