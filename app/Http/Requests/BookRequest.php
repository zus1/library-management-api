<?php

namespace App\Http\Requests;

use App\Const\RouteName;
use App\Http\Requests\Rules\AuthorRules;
use App\Http\Requests\Rules\BookRules;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookRequest extends FormRequest
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
        if($this->route()->action['as'] === RouteName::BOOK_CREATE) {
            return $this->createRules();
        }
        if($this->route()->action['as'] === RouteName::BOOK_UPDATE) {
            return $this->shardRules();
        }

        throw new HttpException(422, 'Unprocessable entity');
    }

    private function createRules(): array
    {
        $rules = [
            ...$this->shardRules(),
            'isbn' => $this->bookRules->isbnRules(),
        ];

        $authorData = $this->input('author');

        if(!isset($authorData['id'])) {
            $rules = [
                ...$rules,
                'author' => 'required|array',
                'author.name' => $this->authorRules->nameRules(),
                'author.dob' => $this->authorRules->dobRules(),
                'author.nationality' => $this->authorRules->nationalityRules(),
            ];
        }

        return $rules;
    }

    private function shardRules(): array
    {
        return [
            'title' => $this->bookRules->titleRules(),
            'dimensions' => $this->bookRules->dimensionsRules(),
            'num_of_pages' => $this->bookRules->numOfPagesRules(),
            'cover_type' => $this->bookRules->coverTypeRules(),
            'year_of_release' => $this->bookRules->yearOfReleaseRules(),
            'edition' => $this->bookRules->editionRules(),
            'genre' => $this->bookRules->genreRules(),
            'type' => $this->bookRules->typeRules(),
        ];
    }
}
