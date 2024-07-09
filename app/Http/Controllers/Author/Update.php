<?php

namespace App\Http\Controllers\Author;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Repository\AuthorRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Update
{
    public function __construct(
        private AuthorRepository $repository,
    ){
    }

    public function __invoke(AuthorRequest $request, Author $author): JsonResponse
    {
        $author = $this->repository->update($request->input(), $author);

        return new JsonResponse(Serializer::normalize($author, 'author:update'));
    }
}
