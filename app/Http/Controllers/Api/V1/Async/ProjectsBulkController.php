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
    use DispatchJobsTrait;

    public function __construct(
        private readonly Dispatcher $batchDispatcher,
        private readonly Application $serviceContainer,
        private readonly string $job = ImportProject::class,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'batchId' => $this->dispatchJobs($request)
        ]);
    }
}
