<?php

namespace App\Http\Controllers\Api\V1\Async;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Queue\JobHistoryResource as JobHistoryResource;
use App\Models\Queue\JobHistory;
use Illuminate\Bus\BatchRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BulkDetailedStatus extends Controller
{
    public function __construct(private readonly BatchRepository $batchRepository)
    {}

    public function __invoke(Request $request, string $batchId): JsonResponse
    {
        if ($batch = $this->batchRepository->find($batchId)) {
            return response()->json([
                'id' => $batch->id,
                'jobName' => $batch->name,
                'totalJobs' => $batch->totalJobs,
                'pendingJobs' => $batch->pendingJobs,
                'failedJobs' => $batch->failedJobs,
                'jobs' => JobHistoryResource::collection(JobHistory::query()->where('batch_id', $batchId)->get())
            ]);
        }

        return response()->json([
            'message' => __('No bulk job found with the ID: :bulkId', ['bulkId' => $batchId])
        ], 404);
    }
}
