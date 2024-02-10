<?php

namespace Feature\Api\V1\Async;

use App\Jobs\Api\V1\ImportTask;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Queue\JobHistory;
use App\Models\TaskStatus;
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

class TasksBulkTest extends ApiTestCase
{
    use RefreshDatabase;

    private array $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $taskOwner = User::factory()->create();
        $taskOwner->assignRole(UserRoles::USER->value);

        $client = User::factory()->create();
        $client->assignRole(UserRoles::CLIENT->value);

        $project = Project::factory()->create([
            'project_status_id' => ProjectStatus::factory()->create(['status' => 'Open']),
            'user_id' => User::factory()->create(),
            'client_id' => $client->id
        ]);

        $taskStatus = TaskStatus::factory()->create(['status' => 'Open']);

        $this->payload = [
            [
                'title' => 'Tasks from bulk api Valid 1',
                'description' => 'small',
                'estimation' => 0,
                'assigned_to' => $taskOwner->id,
                'project_id' => $project->id,
                'task_status' => $taskStatus->status
            ],
            [
                'title' => 'Tasks from bulk api Valid 2',
                'description' => 'some cool description',
                'estimation' => 126,
                'assigned_to' => $taskOwner->id,
                'project_id' => $project->id,
                'task_status' => $taskStatus->status
            ],
            [
                'title' => 'Tasks from bulk api Valid 3',
                'description' => 'some cool description',
                'estimation' => 126,
                'assigned_to' => $client->id,
                'project_id' => $project->id,
                'task_status' => $taskStatus->status
            ],
            [
                'title' => 'Tasks from bulk api Invalid 1',
                'description' => 'some cool description',
                'estimation' => 126,
                'assigned_to' => $taskOwner->id,
                'project_id' => $project->id,
                'task_status' => 'Task status that does not exists'
            ],
            [
                'title' => 'Tasks from bulk api Invalid 2',
                'description' => 'some cool description',
                'estimation' => 126,
                'assigned_to' => $taskOwner->id,
                'project_id' => 7987, // Project does not exist.
                'task_status' => $taskStatus->status
            ],
        ];
    }

    public function test_async_bulk_task_endpoint_dispatch_batched_jobs(): void
    {
        $this->instance( Dispatcher::class, Bus::fake());

        $this->postJson(route('api.async.bulk.tasks'), $this->payload, $this->adminAuthHeader)
            ->assertJson(fn (AssertableJson $json) => $json->has('batchId'))
            ->assertOk();

        Bus::assertBatched(function (PendingBatch $batch) {

            // Assert that jobs were dispatched with correct data.
            $this->assertEquals($batch->jobs[0]->data, $this->payload[0]);
            $this->assertEquals($batch->jobs[1]->data, $this->payload[1]);
            $this->assertEquals($batch->jobs[2]->data, $this->payload[2]);
            $this->assertEquals($batch->jobs[3]->data, $this->payload[3]);
            $this->assertEquals($batch->jobs[4]->data, $this->payload[4]);

            // Verify that correct batch was dispatched.
            return $batch->name === ImportTask::class &&
                $batch->jobs->count() === 5;
        });

        $this->assertDatabaseCount('jobs_history', 0);
    }

    public function test_import_task_job(): void
    {
        Bus::fake();

        $jobs = [
             $this->app->make(ImportTask::class, ['data' => $this->payload[0]]),
             $this->app->make(ImportTask::class, ['data' => $this->payload[1]]),
             $this->app->make(ImportTask::class, ['data' => $this->payload[2]]),
             $this->app->make(ImportTask::class, ['data' => $this->payload[3]]),
             $this->app->make(ImportTask::class, ['data' => $this->payload[4]])
        ];

        /** @var BatchRepository $batchRepository */
        $batchRepository = $this->app->make(BatchRepository::class);
        $batchId = $batchRepository->store(Bus::batch($jobs))->id;

        /** @var ImportTask $job */
        foreach ($jobs as $job) {

            $mockJob = Mockery::mock(Job::class);
            $mockJob->shouldReceive('getJobId')->andReturn(Str::orderedUuid());
            $mockJob->shouldReceive('fail')->zeroOrMoreTimes();

            $job->setJob($mockJob);
            $job->batchId = $batchId;

            $job->handle();
        }

        // Only 3 tasks were valid and actually stored.
        $this->assertDatabaseCount('tasks', 3);

        // Check that job history was stored.
        $this->assertDatabaseCount('jobs_history', 5);
        $jobHistoryRecords = JobHistory::query()->orderBy('id')->get();

        $this->assertEquals(serialize($this->payload[0]), $jobHistoryRecords[0]->payload);
        $this->assertEquals(serialize([]), $jobHistoryRecords[0]->errors);

        $this->assertEquals(serialize($this->payload[1]), $jobHistoryRecords[1]->payload);
        $this->assertEquals(serialize([]), $jobHistoryRecords[1]->errors);

        $this->assertEquals(serialize($this->payload[2]), $jobHistoryRecords[2]->payload);
        $this->assertEquals(serialize([]), $jobHistoryRecords[2]->errors);

        $this->assertEquals(serialize($this->payload[3]), $jobHistoryRecords[3]->payload);
        $this->assertEquals(serialize(['task_status' => [ 0 => 'The selected task status is invalid.' ]]), $jobHistoryRecords[3]->errors);

        $this->assertEquals(serialize($this->payload[4]), $jobHistoryRecords[4]->payload);
        $this->assertEquals(serialize(['project_id' => [ 0 => 'The selected project id is invalid.' ]]), $jobHistoryRecords[4]->errors);
    }
}
