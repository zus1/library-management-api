<?php

namespace App\Http\Controllers\Cat;

use App\Services\Api\CatsApi\Dto\VoteDto;
use App\Services\Api\CatsApi\Request\VoteRequest;
use Zus1\Api\Client\Client;
use Illuminate\Http\JsonResponse;

class Vote
{
    public function __construct(
        private Client $client,
        private VoteRequest $request
    ){
    }

    public function __invoke(): JsonResponse
    {
        /** @var VoteDto $vote */
        $vote = $this->client->call($this->request);

        return new JsonResponse($vote);
    }
}
