<?php

namespace App\Jobs\Api\V1;

use App\Models\Queue\JobHistory;

trait ImportEntityTrait
{
    public function __construct(public readonly array $data = [])
    {}

    public function handle(): void
    {
        $this->saveJobHistory();

        if ($validated = $this->validate()) {
            $this->updateOrCreateEntity($validated);
        }
    }

    private function saveValidationErrorsToJobHistory(array $errors): void
    {
        JobHistory::query()
            ->where('batch_id', $this->batchId)
            ->where('job_id', $this->job->getJobId())
            ->update(['errors' => serialize($errors)]);
    }

    private function saveJobHistory(): void
    {
        JobHistory::query()->insert([
            'batch_id' => $this->batchId,
            'job_id' => $this->job->getJobId(),
            'payload' => serialize($this->data),
            'errors' => serialize([]),
        ]);
    }
}
