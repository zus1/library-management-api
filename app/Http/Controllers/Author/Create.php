<?php

namespace App\Http\Controllers\Author;

use App\Http\Requests\AuthorRequest;
use App\Repository\AuthorRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Create
{
    public function __construct(
        private AuthorRepository $repository,
    ){
    }

    public function __invoke(AuthorRequest $request): JsonResponse
    {
        $author = $this->repository->create($request->input());

        return new JsonResponse(Serializer::normalize($author, ['author:create', 'book:nestedAuthorCreate']));
    }
}
