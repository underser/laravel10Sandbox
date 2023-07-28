<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required',
            'description' => 'sometimes|string',
            'image' => 'file|max:2048|mimes:jpg,png',
            'estimation' => 'sometimes|numeric',
            'user_id' => [
                'sometimes',
                Rule::exists('users', 'id')
            ],
            'project_id' => [
                'sometimes',
                Rule::exists('projects', 'id')
            ],
            'task_status_id' => [
                'sometimes',
                Rule::exists('task_statuses', 'id')
            ]
        ];
    }
}
