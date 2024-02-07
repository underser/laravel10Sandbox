<?php

namespace App\Jobs\Api\V1;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\UserRoles;
use App\Rules\Role;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ImportProject implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(private readonly array $data = [])
    {}

    public function handle(): void
    {
        try {
            $validated = Validator::make($this->data, [
                'name' => 'required',
                'description' => 'string',
                'assigned_to' => [
                    'required',
                    Rule::exists('users', 'id'),
                    new Role([UserRoles::USER, UserRoles::PROJECT_MANAGER])
                ],
                'client' => [
                    'required',
                    Rule::exists('users', 'id'),
                    new Role([UserRoles::CLIENT])
                ],
                'project_status' => [
                    'required',
                    Rule::exists('project_statuses', 'status')
                ],
                'deadline' => 'required|date_format:m/d/Y'
            ])->safe()->toArray();


            Project::query()->updateOrCreate(
                [
                    'title' => $validated['name']
                ], [
                    'description' => $validated['description'],
                    'user_id' => $validated['assigned_to'],
                    'client_id' => $validated['client'],
                    'project_status_id' => ProjectStatus::query()->whereStatus($validated['project_status'])->value('id'),
                    'deadline' => $validated['deadline']
                ]
            );
        } catch (ValidationException $e) {
            $this->fail($e);
        }
    }
}
