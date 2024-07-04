<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Retrieve
{
    public function __invoke(Client $client)
    {
        return new JsonResponse(Serializer::normalize($client, ['client:retrieve', 'libraryCard:nestedClientRetrieve']));
    }
}
