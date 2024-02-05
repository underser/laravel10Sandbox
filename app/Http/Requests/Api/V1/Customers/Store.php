<?php

namespace App\Http\Requests\Api\V1\Customers;

use App\Services\CountryProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('manage users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(CountryProvider $countryProvider): array
    {
        return [
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email|email',
            'phone' => 'numeric',
            'country_code' => Rule::in($countryProvider->getCountries()->pluck('code'))
        ];
    }
}
