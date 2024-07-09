<?php

namespace App\Http\Controllers\Author;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Retrieve
{
    public function __invoke(Author $author): JsonResponse
    {
        return new JsonResponse(Serializer::normalize($author, ['author:retrieve', 'book:nestedAuthorRetrieve']));
    }
}
