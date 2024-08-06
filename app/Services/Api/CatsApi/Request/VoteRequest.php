<?php

namespace App\Services\Api\CatsApi\Request;

use Zus1\Api\Constant\Method;
use Illuminate\Http\Request;

class VoteRequest extends AbstractCatsRequest
{
    public function __construct(
        private Request $request,
    ){
    }

    public function getQuery(): array
    {
        return [];
    }

    public function getBody(): array
    {
        return [
            'image_id' => (string) $this->request->input('image_id'),
            'value' => (int) $this->request->input('vote'),
        ];
    }

    public function getMethod(): string
    {
        return Method::POST;
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            ...$this->baseHeaders(),
        ];
    }

    public function getEndpoint(): string
    {
        return '/votes';
    }

    public function getOptions(): array
    {
        return [];
    }
}
