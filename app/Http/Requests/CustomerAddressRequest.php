<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address1' => 'string|max:255',
            'address2' => 'string|max:255',
            'city' => 'string|max:255',
            'zipcode' => 'numeric|postal_code_with:country_code',
            'country_code' => 'string|max:2',
            'state' => 'string|max:50'
        ];
    }
}
