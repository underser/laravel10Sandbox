<?php

namespace Feature\Api\V1\Async;

use App\Jobs\Api\V1\ImportProject;
use App\Models\ProjectStatus;
use App\Models\Queue\JobHistory;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Bus\BatchRepository;
use Illuminate\Bus\PendingBatch;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery;
use Tests\Feature\Api\V1\ApiTestCase;

class ProjectsBulkTest extends ApiTestCase
{
    use RefreshDatabase;

    private array $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $user->assignRole(UserRoles::USER->value);

        $client = User::factory()->create();
        $client->assignRole(UserRoles::CLIENT->value);

        $projectManager = User::factory()->create();
        $projectManager->assignRole(UserRoles::PROJECT_MANAGER->value);

        $projectStatus = ProjectStatus::factory()->create(['status' => 'Open']);

        $this->payload = [
            [
                'name' => 'Project name Valid 1',
                'description' => 'project 1 description',
                'assigned_to' => $user->id,
                'client' => $client->id,
                'project_status' => $projectStatus->status,
                'deadline' => '12/04/2024'
            ],
            [
                'name' => 'Project name Valid 2',
                'description' => 'project 2 description',
                'assigned_to' => $projectManager->id,
                'client' => $client->id,
                'project_status' => $projectStatus->status,
                'deadline' => '12/04/2024'
            ],
            [
                'name' => 'Project name Invalid 1 (cannot be assigned to client',
                'description' => 'project 2 description',
                'assigned_to' => $client->id,
                'client' => $client->id,
                'project_status' => $projectStatus->status,
                'deadline' => '12/04/2024'
            ],
            [
                'name' => 'Project name Invalid 2 (invalid client)',
                'description' => 'project 2 description',
                'assigned_to' => $projectManager->id,
                'client' => $user->id,
                'project_status' => $projectStatus->status,
                'deadline' => '12/04/2024'
            ],
            [
                'name' => 'Project name Invalid 3',
                'description' => 'project 2 description',
                'assigned_to' => $projectManager->id,
                'client' => $client->id,
                'project_status' => 'Invalid project status',
                'deadline' => '12/04/2024'
            ],
            [
                'name' => 'Project name Invalid 4 (invalid deadline)',
                'description' => 'project 2 description',
                'assigned_to' => $projectManager->id,
                'client' => $client->id,
                'project_status' => $projectStatus->status,
                'deadline' => '2024/12/03'
            ],
        ];
    }

    public function test_async_bulk_project_endpoint_dispatch_batched_jobs(): void
    {
        $this->instance( Dispatcher::class, Bus::fake());

        $this->postJson(route('api.async.bulk.projects'), $this->payload, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) => $json->has('batchId'))
            ->assertOk();

        Bus::assertBatched(function (PendingBatch $batch) {

            // Assert that jobs were dispatched with correct data.
            $this->assertEquals($batch->jobs[0]->data, $this->payload[0]);
            $this->assertEquals($batch->jobs[1]->data, $this->payload[1]);
            $this->assertEquals($batch->jobs[2]->data, $this->payload[2]);
            $this->assertEquals($batch->jobs[3]->data, $this->payload[3]);
            $this->assertEquals($batch->jobs[4]->data, $this->payload[4]);
            $this->assertEquals($batch->jobs[5]->data, $this->payload[5]);

            // Verify that correct batch was dispatched.
            return $batch->name === ImportProject::class &&
                $batch->jobs->count() === 6;
        });

        $this->assertDatabaseCount('jobs_history', 0);
    }

    public function test_import_project_job(): void
    {
        Bus::fake();

        $jobs = [
            $this->app->make(ImportProject::class, ['data' => $this->payload[0]]),
            $this->app->make(ImportProject::class, ['data' => $this->payload[1]]),
            $this->app->make(ImportProject::class, ['data' => $this->payload[2]]),
            $this->app->make(ImportProject::class, ['data' => $this->payload[3]]),
            $this->app->make(ImportProject::class, ['data' => $this->payload[4]]),
            $this->app->make(ImportProject::class, ['data' => $this->payload[5]])
        ];

        /** @var BatchRepository $batchRepository */
        $batchRepository = $this->app->make(BatchRepository::class);
        $batchId = $batchRepository->store(Bus::batch($jobs))->id;

        /** @var ImportProject $job */
        foreach ($jobs as $job) {

            $mockJob = Mockery::mock(Job::class);
            $mockJob->shouldReceive('getJobId')->andReturn(Str::orderedUuid());
            $mockJob->shouldReceive('fail')->zeroOrMoreTimes();

            $job->setJob($mockJob);
            $job->batchId = $batchId;

            $job->handle();
        }

        // Only 2 projects were valid and actually stored.
        $this->assertDatabaseCount('projects', 2);

        // Check that job history was stored.
        $this->assertDatabaseCount('jobs_history', 6);
        $jobHistoryRecords = JobHistory::query()->orderBy('id')->get();

        $this->assertEquals(serialize($this->payload[0]), $jobHistoryRecords[0]->payload);
        $this->assertEquals(serialize([]), $jobHistoryRecords[0]->errors);

        $this->assertEquals(serialize($this->payload[1]), $jobHistoryRecords[1]->payload);
        $this->assertEquals(serialize([]), $jobHistoryRecords[1]->errors);

        $this->assertEquals(serialize($this->payload[2]), $jobHistoryRecords[2]->payload);
        $this->assertEquals(
            serialize(['assigned_to' => [ 0 => 'User you are assigning to does not have an appropriate role.' ]]),
            $jobHistoryRecords[2]->errors
        );

        $this->assertEquals(serialize($this->payload[3]), $jobHistoryRecords[3]->payload);
        $this->assertEquals(
            serialize(['client' => [ 0 => 'Client does not have an appropriate role.' ]]),
            $jobHistoryRecords[3]->errors
        );

        $this->assertEquals(serialize($this->payload[4]), $jobHistoryRecords[4]->payload);
        $this->assertEquals(
            serialize(['project_status' => [ 0 => 'The selected project status is invalid.' ]]),
            $jobHistoryRecords[4]->errors
        );

        $this->assertEquals(serialize($this->payload[5]), $jobHistoryRecords[5]->payload);
        $this->assertEquals(
            serialize(['deadline' => [ 0 => 'The deadline field must match the format m/d/Y.' ]]),
            $jobHistoryRecords[5]->errors
        );
    }
}
