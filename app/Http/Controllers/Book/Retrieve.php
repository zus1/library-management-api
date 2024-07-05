<?php

namespace App\Http\Controllers\Book;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Retrieve
{
    public function __invoke(Book $book): JsonResponse
    {
        return new JsonResponse(Serializer::normalize($book, ['book:retrieve', 'author:nestedBookRetrieve']));
    }
}
