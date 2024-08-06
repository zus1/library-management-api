<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Repository\Elastic\BookRepository;
use App\Services\ElasticSearch\Constant\Pagination;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Search
{
    public function __construct(
        private BookRepository $elasticRepository,
    ){
    }

    public function __invoke(BookRequest $request): JsonResponse
    {
        $results = $this->elasticRepository->search(
            query: (string) $request->query('query'),
            page: (int) $request->query('page', Pagination::DEFAULT_PAGE),
            size: (int) $request->query('size', Pagination::DEFAULT_SIZE),
        );

        return new JsonResponse(Serializer::normalize($results, ['book:collection', 'author:nestedBookCollection']));
    }
}
