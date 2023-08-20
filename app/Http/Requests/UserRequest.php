<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $commonRules = [
            "email" => ['required', 'email','min:5',Rule::exists('users','email')],
            "password" => ['required', 'string','min:5']
        ];

        // Define specific rules based on the route name
        if ($this->routeIs('register')) {
            $registrationRules = [
                "name" => ['required','string','min:3'],
                "phone" => ['required','string','regex:/^\d{10,}$/'],
                "email" => [$commonRules["email"],  Rule::unique('users', 'email')],
                "password" => [$commonRules["password"],'confirmed']
            ];
            return $registrationRules;
        } elseif ($this->routeIs('login')) {
            return $commonRules;
        }
        return [];
    }
}


