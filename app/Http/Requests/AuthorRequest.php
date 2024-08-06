<?php

namespace App\Http\Requests;

use App\Const\RouteName;
use App\Http\Requests\Rules\AuthorRules;
use App\Http\Requests\Rules\BookRules;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorRequest extends FormRequest
{
    public function __construct(
        private BookRules $bookRules,
        private AuthorRules $authorRules,
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
        if($this->route()->action['as'] === RouteName::AUTHOR_CREATE) {
            return $this->createRules();
        }
        if($this->route()->action['as'] === RouteName::AUTHOR_UPDATE) {
            return $this->updateRules();
        }

        throw new HttpException(422, 'Unprocessable entity');
    }

    private function createRules(): array
    {
        return [
            ...$this->sharedRules(),
            'name' => $this->authorRules->nameRules(unique: true),
            'books' => 'required|array',
            'books.*.title' => $this->bookRules->titleRules(),
            'books.*.isbn' => $this->bookRules->isbnRules(),
            'books.*.dimensions' => $this->bookRules->dimensionsRules(),
            'books.*.num_of_pages' => $this->bookRules->numOfPagesRules(),
            'books.*.cover_type' => $this->bookRules->coverTypeRules(),
            'books.*.year_of_release' => $this->bookRules->yearOfReleaseRules(),
            'books.*.edition' => $this->bookRules->editionRules(),
            'books.*.genre' => $this->bookRules->genreRules(),
            'books.*.type' => $this->bookRules->typeRules(),
        ];
    }

    private function updateRules()
    {
        return [
            'name' => $this->authorRules->nameRules(unique: false),
            ...$this->sharedRules(),
        ];
    }

    private function sharedRules(): array
    {
        return [
            'dob' => $this->authorRules->dobRules(),
            'nationality' => $this->authorRules->nationalityRules(),
        ];
    }
}
