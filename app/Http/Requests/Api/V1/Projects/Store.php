<?php

namespace App\Http\Requests\Api\V1\Projects;

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
            'title' => 'required|required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
            'user_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'client_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'project_status_id' => [
                'required',
                Rule::exists('project_statuses', 'id')
            ],
            'deadline' => 'required|date'
        ];
    }
}
