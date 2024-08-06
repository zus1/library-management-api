<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Repository\Elastic\BookRepository;
use App\Services\ElasticSearch\Constant\Pagination;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class AutocompleteSearch
{
    public function __construct(
        private BookRepository $elasticRepository,
    ){
    }

    public function __invoke(BookRequest $request): JsonResponse
    {
        $results = $this->elasticRepository->autocomplete(
            query: lcfirst((string) $request->query('query')),
            size: $request->query('size', Pagination::DEFAULT_SIZE),
        );

        return new JsonResponse(Serializer::normalize($results, ['book:autoComplete']));
    }
}
