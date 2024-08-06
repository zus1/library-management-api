<?php

namespace App\Services\ApiIntegration\Interface;

use Illuminate\Http\Client\Response;

interface ResponseInterface
{
    public function handleResponse(RequestInterface $request, Response $response);
}
