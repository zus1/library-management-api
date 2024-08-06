<?php

namespace App\Services\ApiIntegration\Interface;

interface RequestInterface
{
    public function getQuery(): array;

    public function getBody(): array;

    public function getMethod(): string;

    public function getHeaders(): array;

    public function getBaseUrl(): string;

    public function getEndpoint(): string;

    public function getOptions(): array;
}
