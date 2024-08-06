<?php

namespace App\Services\Api\CatsApi\Request;

use Zus1\Api\Constant\Method;
use Illuminate\Http\Request;

class ImagesRequest extends AbstractCatsRequest
{

    public function __construct(
        private Request $request,
    ){
    }

    public function getQuery(): array
    {
        return [
            'limit' => $this->request->query('limit')
        ];
    }

    public function getBody(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return Method::GET;
    }

    public function getHeaders(): array
    {
        return $this->baseHeaders();
    }

    public function getEndpoint(): string
    {
        return '/images/search';
    }

    public function getOptions(): array
    {
        return [];
    }
}
