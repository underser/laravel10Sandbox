<?php

namespace App\Http\Requests\Api\V1\Tasks;

use App\Models\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\InputBag;

class Update extends FormRequest
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
            'title' => 'sometimes|required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
            'estimation' => 'numeric',
            'assigned_to' => [
                Rule::exists('users', 'id')
            ],
            'project_id' => [
                Rule::exists('projects', 'id')
            ],
            'task_status' => [
                Rule::exists('task_statuses', 'status')
            ]
        ];
    }

    protected function passedValidation(): void
    {
        /** @var InputBag $inputSource */
        $inputSource = $this->getInputSource();

        if ($this->input('assigned_to')) {
            $inputSource->add(['user_id' => $this->input('assigned_to')]);
        }

        if ($this->input('task_status')) {
            $inputSource->add(['task_status_id' => TaskStatus::whereStatus($this->input('task_status'))->value('id')]);
        }
    }
}
