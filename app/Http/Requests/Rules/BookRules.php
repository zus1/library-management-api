<?php

namespace App\Http\Requests\Rules;

use App\Const\BookCoverType;
use Carbon\Carbon;
use Closure;
use Illuminate\Validation\Rule;

class BookRules
{
    public function titleRules(): string
    {
        return 'required|string|max:100';
    }

    public function isbnRules(): string
    {
        return 'required|string|unique:books|regex:/(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)/';
    }

    public function dimensionsRules(): string
    {
        return 'required|string';
    }

    public function numOfPagesRules(): string
    {
        return 'required|integer|min:1';
    }

    public function coverTypeRules(): array
    {
        return [
            'required',
            'string',
            Rule::in(BookCoverType::getValues()),
        ];
    }

    public function yearOfReleaseRules(): array
    {
        return [
            'required',
            'date',
            function (string $attribute, string $value, Closure $fail) {
                if((new Carbon($value))->greaterThanOrEqualTo(Carbon::now())) {
                    $fail(sprintf('%s must be date in past', $attribute));
                }
            },
        ];
    }

    public function editionRules(): string
    {
        return 'required|integer';
    }

    public function genreRules(): string
    {
        return 'required|string|max:50';
    }

    public function typeRules(): string
    {
        return 'required|string|max:50';
    }
}
