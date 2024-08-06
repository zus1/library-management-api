<?php

namespace App\Services\ElasticSearch;


use App\Services\ElasticSearch\Constant\Pagination;
use App\Services\ElasticSearch\DataMappers\DataMapper;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Helper\Iterators\SearchResponseIterator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ElasticSearch
{
    public function __construct(
        private Client $client,
    ){
    }

    public function search(
        string $index,
        array $query,
        int $page = Pagination::DEFAULT_PAGE,
        int $size = Pagination::DEFAULT_SIZE
    ): Collection|LengthAwarePaginator {
        $params = [
            'index' => $index,
            'body' => [
                'query' => $query,
            ],
        ];

        return $this->getResults($params, $page, $size);
    }

    public function rawSearch(array $params, int $page): Collection|LengthAwarePaginator
    {
        return $this->getResults($params, $page);
    }

    private function getResults(array $params, int $page, int $size=0): Collection|LengthAwarePaginator
    {
        $results = $page === 0 ? $this->performSearch($params) : $this->performPaginatedSearch($params, $page, $size);

        /** @var DataMapper $mapper */
        $mapper = App::make(DataMapper::class);

        return $mapper->map($results);
    }

    private function performSearch(array $params): array
    {
        return $this->client->search($params)->asArray();
    }

    private function performPaginatedSearch(array $params, int $page, int $size): array
    {
        if($size !== 0) {
            $params = [
                ...$params,
                'size' => $size,
                'scroll' => '5m',
            ];
        }


        $pages = new SearchResponseIterator($this->client, $params);
        foreach ($pages as $pageKey => $results) {
            if($pageKey === $page -1) {
                return $results;
            }
        }

        return [];
    }

    public function createIndex(string $index): bool
    {
        $params = [
            'index' => $index,
            'body' => [
                'mappings' => $this->getMappings($index)
            ],
        ];

        if($this->client->indices()->exists(['index' => $index])) {
            return false;
        }

        return $this->client->indices()->create($params)->asBool();
    }

    private function getMappings(string $index): array
    {
        $mappings = [];
        $this->addIndexes($index, $mappings);

        return $mappings;
    }

    private function addIndexes(string $index, array &$mappings): void
    {
        $properties = (array) config('elasticsearch.indexes');
        if(!array_key_exists($index, $properties)) {
            throw new HttpException(500, 'Index not found, did you forget to add it to elasticsearch.php?');
        }

        $mappings['properties'] = $properties[$index];
    }

    public function add(string $index, array $data, int $id, array $nested): bool
    {
        $params = [
            'index' => $index,
            'id' => $id,
            'body' => $this->getAddData($data, $nested),
        ];

       return $this->client->index($params)->asBool();
    }

    private function getAddData(array $data, array $nested = []): array
    {
        if($nested === []) {
            return $data;
        }

        return [
            ...$data,
            ...$nested
        ];
    }

    public function update(string $index, array $data, int $id): bool
    {
        $params = [
            'index' => $index,
            'id' => $id,
            'body' => [
                'doc' => $data,
            ]
        ];

        return $this->client->update($params)->asBool();
    }

    public function remove(string $index, int $id): bool
    {
        $params = [
            'index' => $index,
            'id' => $id,
        ];

        return $this->client->delete($params)->asBool();
    }
}
