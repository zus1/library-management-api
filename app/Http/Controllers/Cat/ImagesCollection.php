<?php

namespace App\Http\Controllers\Cat;

use App\Services\Api\CatsApi\Request\ImagesRequest;
use App\Services\Aws\OpenSearch;
use Zus1\Api\Client\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ImagesCollection
{
    public function __construct(
        private Client $client,
        private ImagesRequest $imagesRequest,
        private OpenSearch $openSearch,
    ){
    }

    public function __invoke():  JsonResponse
    {
        $this->openSearch->createIndex();

        /** @var Collection $images */
        $images = $this->client->call($this->imagesRequest);

        return new JsonResponse($images);
    }
}
