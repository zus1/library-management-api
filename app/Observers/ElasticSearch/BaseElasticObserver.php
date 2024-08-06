<?php

namespace App\Observers\ElasticSearch;

use Zus1\Elasticsearch\ElasticSearch;
use Illuminate\Log\Logger;

abstract class BaseElasticObserver
{
    public function __construct(
        protected ElasticSearch $elasticSearch,
        private Logger $logger,
    ){
    }

    protected function log(bool $result, int $id, string $index, string $action): void
    {
        $method = $result === true ? 'info' : 'error';
        $messageSuffix = $result === true ? $action : 'could not be '.$action;

        $this->logger->$method(sprintf('Entry with id %d %s to/from index %s', $id, $messageSuffix, $index));
    }
}
