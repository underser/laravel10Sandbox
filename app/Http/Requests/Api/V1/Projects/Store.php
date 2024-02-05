<?php

namespace App\Http\Requests\Api\V1\Projects;

use App\Models\ProjectStatus;
use App\Models\UserRoles;
use App\Rules\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('manage projects');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
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
        ];
    }

    protected function passedValidation(): void
    {
        $this->getInputSource()->add([
            'title' => $this->input('name'),
            'user_id' => $this->input('assigned_to'),
            'client_id' => $this->input('client'),
            'project_status_id' => ProjectStatus::query()->whereStatus($this->input('project_status'))->value('id')
        ]);
    }
}
