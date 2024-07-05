<?php

namespace App\Http\Controllers\Book;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Repository\BookRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Update
{
    public function __construct(
        private BookRepository $repository
    ){
    }

    public function __invoke(BookRequest $request, Book $book): JsonResponse
    {
        $book = $this->repository->update($request->input(), $book);

        return new JsonResponse(Serializer::normalize($book, 'book:update'));
    }
}
