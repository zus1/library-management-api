<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\ClientRequest;
use App\Repository\ClientRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Create
{
    public function __construct(
        private ClientRepository $repository,
    ){
    }

    public function __invoke(ClientRequest $request): JsonResponse
    {
        $client = $this->repository->create($request->input());

        return new JsonResponse(Serializer::normalize($client, ['client:create', 'libraryCard:nestedClientCreate']));
    }
}
