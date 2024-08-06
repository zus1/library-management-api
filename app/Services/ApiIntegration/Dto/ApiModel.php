<?php

namespace App\Services\ApiIntegration\Dto;

/**
 * Base class for all api models. Every api model (mapped by DataMapper) needs to extend this class
 */
class ApiModel implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
