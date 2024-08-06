<?php

namespace App\Http\Requests\Rules;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;

class AuthorRules
{
    public function nameRules(bool $unique): array
    {
        $rules = [
            'required',
            'string',
            'max:100',
        ];

        if($unique === true) {
            $rules[] = Rule::unique('authors', 'name');
        }

        return $rules;
    }

    public function dobRules(): string
    {
        return 'required|date';
    }

    public function nationalityRules(): string
    {
        return 'required|string';
    }
}
