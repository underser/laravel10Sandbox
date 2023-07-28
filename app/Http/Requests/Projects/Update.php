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
            'title' => 'sometimes|required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
            'user_id' => [
                Rule::exists('users', 'id')
            ],
            'client_id' => [
                Rule::exists('users', 'id')
            ],
            'project_status_id' => [
                Rule::exists('project_statuses', 'id')
            ],
            'deadline' => 'date'
        ];
    }
}
