<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repository\ClientRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Update
{
    public function __construct(
        private ClientRepository $repository,
    ){
    }

    public function __invoke(ClientRequest $request, Client $client)
    {
        $client = $this->repository->update($request->input(), $client);

        return new JsonResponse(Serializer::normalize($client, 'client:update'));
    }
}
