<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedRolesAndPermission();
        $commonStatuses = collect(['Open', 'In Progress', 'Postponed', 'Estimation', 'Done', 'Closed']);
        $userIds = User::factory(30)->create()->modelKeys();

        $commonStatuses->each(function ($status) {
            ProjectStatus::factory()->create([
                'status' => $status
            ]);
            TaskStatus::factory()->create([
                'status' => $status
            ]);
        });

        $commonStatuses->merge(['QA verification', 'Question', 'Implemented'])->each(function ($status) {
            TaskStatus::factory()->create([
                'status' => $status
            ]);
        });

        $projectStatuses = ProjectStatus::all();
        $taskStatuses = TaskStatus::all();

        foreach (Client::factory(200)->create() as $client) {
            $project = Project::factory()->create([
                'user_id' => $userIds[array_rand($userIds)],
                'client_id' => $client->id,
                'project_status_id' => $projectStatuses->random(1)->first()->id
            ]);

            Task::factory(random_int(10, 40))->create([
                'user_id' => $userIds[array_rand($userIds)],
                'project_id' => $project->id,
                'task_status_id' => $taskStatuses->random(1)->first()->id,
            ]);
        }
    }

    private function seedRolesAndPermission()
    {
        $permissions = [
            'manage users',
            'manage clients',
            'manage projects',
            'manage tasks'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'Administrator'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'Client'])->givePermissionTo(
            Permission::query()->where([
                ['name', '=', 'manage projects'],
                ['name', '=', 'manage tasks']
            ])
        );
        Role::create(['name' => 'Project Manager'])->givePermissionTo(
            Permission::query()->where([
                ['name', '=', 'manage projects'],
                ['name', '=', 'manage tasks']
            ])
        );
        Role::create(['name' => 'User'])->givePermissionTo(
            Permission::query()->where([
                ['name', '=', 'manage tasks']
            ])
        );
    }
}
