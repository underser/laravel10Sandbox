<?php

namespace App\Http\Requests\Api\V1\Projects;

use App\Models\ProjectStatus;
use App\Models\UserRoles;
use App\Rules\Role;
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
            'name' => 'sometimes|required',
            'description' => 'string',
            'image' => 'file|max:2048|mimes:jpg,png',
            'assigned_to' => [
                Rule::exists('users', 'id'),
                new Role([UserRoles::USER, UserRoles::PROJECT_MANAGER])
            ],
            'client' => [
                Rule::exists('users', 'id'),
                new Role([UserRoles::CLIENT])
            ],
            'project_status' => [
                Rule::exists('project_statuses', 'status')
            ],
            'deadline' => 'date_format:m/d/Y'
        ];

    }

    protected function passedValidation(): void
    {
        /** @var InputBag $inputSource */
        $inputSource = $this->getInputSource();

        if ($this->input('name')) {
            $inputSource->add(['title' => $this->input('name')]);
        }

        if ($this->input('assigned_to')) {
            $inputSource->add(['user_id' => $this->input('assigned_to')]);
        }

        if ($this->input('client')) {
            $inputSource->add(['client_id' => $this->input('client')]);
        }

        if ($this->input('project_status')) {
            $inputSource->add([
                'project_status_id' =>
                    ProjectStatus::query()->whereStatus($this->input('project_status'))->value('id')
            ]);
        }
    }
}
