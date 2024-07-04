<?php

namespace App\Http\Requests\Rules;

use App\Const\Seniority;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRules
{
    public function getRules(): array
    {
        return [
            'email' => 'required|email|unique:librarians',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->letters()
                    ->symbols()
                    ->uncompromised()
            ],
            'confirm_password' => 'required|same:password',
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:50',
            'dob' => 'required|date',
            'city' => 'string',
            'employed_at' => 'required|date',
            'social_security_number' => 'required|string|size:8',
            'seniority' => [
                'required',
                Rule::in(Seniority::getValues())
            ],
        ];
    }
}
