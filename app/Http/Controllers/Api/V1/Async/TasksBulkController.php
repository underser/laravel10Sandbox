<?php

namespace App\Http\Controllers\Api\V1\Async;

use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\ImportTask;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksBulkController extends Controller
{
    use DispatchJobsTrait;

    public function __construct(
        private readonly Dispatcher $batchDispatcher,
        private readonly Application $serviceContainer,
        private readonly string $job = ImportTask::class
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'batchId' => $this->dispatchJobs($request)
        ]);
    }
}
