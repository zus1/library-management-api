<?php

namespace App\Http\Controllers\Author;

use App\Models\Author;
use Illuminate\Http\JsonResponse;

class Delete
{
    public function __invoke(Author $author): JsonResponse
    {
        $author->delete();

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
