<?php

namespace App\Http\Requests;

use App\Const\ImageType;
use App\Rules\Ratio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => Rule::in(ImageType::getValues()),
            'image' => [
                'required',
                File::types(['image/png', 'image/jpg', 'image/jpeg'])
                    ->max("2mb"),
                App::make(Ratio::class),
            ],
        ];
    }
}
