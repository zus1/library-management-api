<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Repository\BookRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Create
{
    public function __construct(
        private BookRepository $repository,
    ){
    }

    public function __invoke(BookRequest $request): JsonResponse
    {
        $book = $this->repository->create($request->input());

        return new JsonResponse(Serializer::normalize($book, ['book:create', 'author:nestedBookCreate']));
    }
}
