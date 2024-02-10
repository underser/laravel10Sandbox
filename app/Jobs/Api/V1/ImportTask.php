<?php

namespace App\Jobs\Api\V1;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ImportTask implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, ImportEntityTrait;

    private function validate(): bool|array
    {
        try {
            return Validator::make($this->data, [
                'title' => 'required',
                'description' => 'string',
                'estimation' => 'numeric',
                'assigned_to' => [
                    'required',
                    Rule::exists('users', 'id')
                ],
                'project_id' => [
                    'required',
                    Rule::exists('projects', 'id')
                ],
                'task_status' => [
                    'required',
                    Rule::exists('task_statuses', 'status')
                ]
            ])->safe()->toArray();
        } catch (ValidationException $e) {
            $this->saveValidationErrorsToJobHistory($e->errors());
            $this->fail($e);
        }

        return false;
    }

    private function updateOrCreateEntity(array $validated): void
    {
        Task::query()->updateOrCreate(
            [
                'title' => $validated['title']
            ], [
                'description' => $validated['description'],
                'estimation' => $validated['estimation'],
                'user_id' => $validated['assigned_to'],
                'project_id' => $validated['project_id'],
                'task_status_id' => TaskStatus::whereStatus($validated['task_status'])->value('id'),
            ]
        );
    }
}
