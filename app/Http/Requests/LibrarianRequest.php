<?php

namespace App\Http\Requests;

use App\Const\RouteName;
use App\Http\Requests\Rules\RegisterRules;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LibrarianRequest extends FormRequest
{
    public function __construct(
        private RegisterRules $registerRules,
    ){
        parent::__construct();
    }

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
        if($this->route()->action['as'] === RouteName::REGISTER) {
            return $this->registerRules->getRules();
        }
        if($this->route()->action['as'] === RouteName::LIBRARIAN_TOGGLE_ACTIVE) {
            return $this->getToggleActiveRules();
        }

        throw new HttpException(422, 'Unprocessable entity');
    }

    private function getToggleActiveRules(): array
    {
        return [
            'active' => 'in:true,false'
        ];
    }
}
