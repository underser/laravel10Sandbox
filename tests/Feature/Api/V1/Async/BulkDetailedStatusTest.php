<?php

namespace Feature\Api\V1\Async;

use App\Jobs\Api\V1\ImportTask;
use App\Models\Queue\JobHistory;
use Illuminate\Bus\BatchRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Api\V1\ApiTestCase;

class BulkDetailedStatusTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_bulk_detailed_status_endpoint_provide_correct_response(): void
    {
        Bus::fake();
        /** @var BatchRepository $batchRepository */
        $batchRepository = $this->app->make(BatchRepository::class);
        $job = $this->app->make(ImportTask::class);
        $batchId = $batchRepository->store(Bus::batch([$job])->name(ImportTask::class))->id;

        JobHistory::factory()->create([
            'batch_id' => $batchId,
            'job_id' => Str::orderedUuid(),
            'payload' => serialize(['title' => '']),
            'errors' => serialize(['title' => [0 => 'The title field is required.']])
        ]);

        JobHistory::factory()->create([
            'batch_id' => $batchId,
            'job_id' => Str::orderedUuid(),
            'payload' => serialize(['title' => 'Valid title field']),
            'errors' => serialize([])
        ]);

        $this->getJson(route('api.async.bulk.detailed-status', $batchId), $this->adminAuthHeader)
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('id', $batchId)
                    ->where('jobName', ImportTask::class)
                    ->where('totalJobs', 0)
                    ->where('pendingJobs', 0)
                    ->where('failedJobs', 0)
                    ->has('jobs.0', fn (AssertableJson $json) =>
                        $json->has('payload', fn (AssertableJson $json) =>
                            $json->where('title', '')
                        )
                        ->where('errors', ['title' => [0 => 'The title field is required.']])
                    )
                    ->has('jobs.1', fn (AssertableJson $json) =>
                        $json->has('payload', fn (AssertableJson $json) =>
                            $json->where('title', 'Valid title field')
                        )
                        ->where('errors', [])
                    )
            );
    }
}
