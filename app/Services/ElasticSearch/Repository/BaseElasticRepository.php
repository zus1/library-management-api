<?php

namespace App\Services\ElasticSearch\Repository;

use App\Services\ElasticSearch\Query\Builder;
use Illuminate\Support\Facades\App;

class BaseElasticRepository
{
    protected const INDEX = '';

    protected function getBuilder(): Builder
    {
        /** @var Builder $builder */
        $builder = App::make(Builder::class);

        return $builder->forIndex(static::INDEX);
    }
}
