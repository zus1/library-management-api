<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\JsonResponse;

class Delete
{
    public function __invoke(Client $client): JsonResponse
    {
        $client->delete();

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
