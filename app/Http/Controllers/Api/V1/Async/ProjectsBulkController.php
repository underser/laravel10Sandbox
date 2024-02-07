<?php

namespace App\Http\Controllers\Api\V1\Async;

use App\Http\Controllers\Controller;
use App\Jobs\Api\V1\ImportProject;
use Illuminate\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectsBulkController extends Controller
{
    public function __construct(
        private readonly Dispatcher $batchDispatcher,
        private readonly Application $serviceContainer
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $jobs = [];

        foreach ($request->getPayload()->all() as $projectItem) {
            $jobs[] = $this->serviceContainer->make(ImportProject::class, ['data' => $projectItem]);
        }

        $batch = $this->batchDispatcher->batch($jobs)->dispatch();

        return response()->json([
            'batchId' => $batch->id
        ]);
    }
}
