<?php

namespace App\Services\ApiIntegration\Interface;

use App\Services\ApiIntegration\Dto\ApiModel;
use Illuminate\Support\Collection;

interface DataMapperInterface
{
    /**
     * @return ApiModel|ApiModel[]
     */
    public function map(array $data): ApiModel|Collection;
}
