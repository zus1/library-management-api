<?php

namespace App\Http\Requests\Rules;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\DatabaseRule;

class AuthorRules
{
    public function nameRules(): array
    {
        return [
            'required',
            'string',
            'max:100',
            Rule::unique('authors', 'name'),
        ];
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
