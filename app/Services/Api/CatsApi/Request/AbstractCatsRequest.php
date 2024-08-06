<?php

namespace App\Services\Api\CatsApi\Request;

use Zus1\Api\Interface\RequestInterface;

abstract class AbstractCatsRequest implements RequestInterface
{
    public function getBaseUrl(): string
    {
        return 'https://api.thecatapi.com/v1';
    }

    protected function baseHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            //bad practice but it will do for testing, use env and config
            'x-api-key' => 'live_O7RZUIb40u9aFEVQLIyjFbo1zMpyfJ1QugsSRbeKVuQTqbTPPuaJPiqUzSXq0K1Z'
        ];
    }
}
