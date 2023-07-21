<?php

namespace App\Http\Requests\Projects;

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
            'user_id' => [
                'sometimes',
                Rule::exists('users', 'id')
            ],
            'client_id' => [
                'sometimes',
                Rule::exists('clients', 'id')
            ],
            'project_status_id' => [
                'sometimes',
                Rule::exists('project_statuses', 'id')
            ],
            'deadline' => 'sometimes|date'
        ];
    }
}
