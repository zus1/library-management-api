<?php

namespace Database\Factories;

use Zus1\Elasticsearch\ElasticSearch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class ElasticAwareFactoryGenerator
{
    public static function instance(string $factoryClass): Factory
    {
        /** @var ElasticAwareFactory $factory */
        $factory = $factoryClass::factory();
        $factory->setElasticSearchService(App::make(ElasticSearch::class));

        return $factory;
    }
}
