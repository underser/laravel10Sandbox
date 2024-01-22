<?php

namespace App\Http\Requests\Api\V1\Tasks;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('manage tasks');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
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
        ];
    }

    protected function passedValidation(): void
    {
        $this->getInputSource()->add([
            'user_id' => $this->input('assigned_to'),
            'task_status_id' => TaskStatus::whereStatus($this->input('task_status'))->value('id'),
        ]);
    }
}
