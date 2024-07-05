<?php

namespace App\Http\Controllers\Book;

use App\Models\Book;
use App\Repository\BookRepository;
use Illuminate\Http\JsonResponse;

class Delete
{
    public function __construct(
        private BookRepository $repository
    ){
    }

    public function __invoke(Book $book): JsonResponse
    {
        $this->repository->delete($book);

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
