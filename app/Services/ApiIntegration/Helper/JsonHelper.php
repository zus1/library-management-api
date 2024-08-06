<?php

namespace App\Services\ApiIntegration\Helper;

class JsonHelper
{
    public function isJson(?string $payload): bool
    {
        if(is_null($payload) || $payload === '') {
            return false;
        }

        try {
            json_decode($payload, true, 521, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return false;
        }

        return true;
    }
}
