<?php

namespace App\Http\Requests;

use App\Const\LibraryCardType;
use App\Const\RouteName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClientRequest extends FormRequest
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
        if($this->route()->action['as'] === RouteName::CLIENT_CREATE) {
            return $this->createRules();
        }
        if($this->route()->action['as'] === RouteName::CLIENT_UPDATE) {
            return $this->sharedRules();
        }

        throw new HttpException(422, 'Unprocessable entity');
    }

    private function createRules(): array
    {
        return [
            ...$this->sharedRules(),
            'library_card' => 'array',
            'library_card.type' => Rule::in(LibraryCardType::getValues()),
        ];
    }

    private function sharedRules(): array
    {
        return [
            'preferences' => 'array',
            'phone_number' => 'required|regex:/^\\+?[1-9][0-9]{7,14}$/',
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:50',
            'dob' => 'required|date',
            'city' => 'string',
        ];
    }
}
