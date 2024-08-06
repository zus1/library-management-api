<?php

namespace App\Services\ApiIntegration\Interface;

use Illuminate\Http\Client\Response;

interface ExceptionHandlerInterface
{
    public function handleException(Response $response, RequestInterface $request): void;
}
