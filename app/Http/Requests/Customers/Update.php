<?php

namespace App\Http\Requests\Customers;

use App\Services\CountryProvider;
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
    public function rules(CountryProvider $countryProvider): array
    {
        return [
            'name' => 'sometimes|required|max:50',

            'email' => [
                'sometimes',
                'required',
                Rule::unique('users', 'email')->ignoreModel(request()->user)
            ],
            'phone' => 'numeric',
            'country_code' => Rule::in($countryProvider->getCountries()->pluck('code'))
        ];

    }
}
