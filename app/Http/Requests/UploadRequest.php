<?php

namespace App\Http\Requests;

use App\Const\ImageType;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
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
            'image' => [
                'required',
                File::types(['image/png', 'image/jpg', 'image/jpeg'])
                    ->max("2mb"),
                function (string $attribute, UploadedFile $value, Closure $fail) {
                    $dimensions = $value->dimensions();

                    $neededRation = ImageType::RATIO;
                    $ratio = $dimensions[1]/$dimensions[0];

                    $lowerBoundary = $neededRation - 0.2;
                    $upperBoundary = $neededRation + 0.2;

                    if($ratio < $lowerBoundary || $ratio > $upperBoundary) {
                        $fail(sprintf(
                            'Dimension ratio (height/with) for %s needs to be between %d and %d',
                            $attribute,
                            $lowerBoundary,
                            $upperBoundary
                        ));
                    }
                }
            ],
        ];
    }
}
