<?php

namespace App\Http\Controllers\Api\V1\Async;

use Illuminate\Http\Request;

trait DispatchJobsTrait
{
    private function dispatchJobs(Request $request): string
    {
        $jobs = [];

        foreach ($request->getPayload()->all() as $projectItem) {
            $jobs[] = $this->serviceContainer->make($this->job, ['data' => $projectItem]);
        }

        return $this->batchDispatcher->batch($jobs)->name($this->job)->dispatch()->id;
    }
}
