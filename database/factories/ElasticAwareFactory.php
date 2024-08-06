<?php

namespace Database\Factories;

use Zus1\Elasticsearch\ElasticSearch;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class ElasticAwareFactory extends Factory
{
    protected static ElasticSearch $_elasticSearch;

    public function setElasticSearchService(ElasticSearch $elasticSearch): void
    {
        self::$_elasticSearch = $elasticSearch;
    }
}
