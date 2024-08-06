<?php

namespace App\Services\ElasticSearch\Query;

use App\Services\ElasticSearch\Constant\Pagination;
use App\Services\ElasticSearch\ElasticSearch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class Builder
{
    private array $params = [
        'index' => '',
        'body' => [
            'query' => [],
        ],
    ];

    private array $query = [];

    private int $page = Pagination::DEFAULT_PAGE;

    public function __construct(
        private ElasticSearch $search,
    ){
    }

    public function new(): Builder
    {
        return App::make(self::class);
    }

    public function forIndex(string $index): self
    {
        $this->params['index'] = $index;

        return $this;
    }

    public function whereBoolMustMatch(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must', $this->query['bool']);
        $this->addElement('match', element: [$field => $value], queryPart: $this->query['bool']['must']);

        return $this;
    }

    public function whereBoolMustPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must', $this->query['bool']);
        $this->addElement('prefix', element: [$field => $value], queryPart: $this->query['bool']['must']);

        return $this;
    }

    public function whereBoolMustTerm(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must', $this->query['bool']);
        $this->addElement('term', element: [$field => $value], queryPart: $this->query['bool']['must']);


        return $this;
    }

    public function whereBoolMustMatchBoolPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must', $this->query['bool']);
        $this->addElement('match_bool_prefix', element: [$field => $value], queryPart: $this->query['bool']['must']);

        return $this;
    }

    public function whereBoolMustNotMatch(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must_not', $this->query['bool']);
        $this->addElement('match', element: [$field => $value], queryPart: $this->query['bool']['must_not']);

        return $this;
    }

    public function whereBoolMustNotPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must_not', $this->query['bool']);
        $this->addElement('prefix', element: [$field => $value], queryPart: $this->query['bool']['must_not']);

        return $this;
    }

    public function whereBoolMostNotTerm(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must_not', $this->query['bool']);
        $this->addElement('term', element: [$field => $value], queryPart: $this->query['bool']['must_not']);

        return $this;
    }

    public function whereBoolMustNotMatchBoolPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must_not', $this->query['bool']);
        $this->addElement('match_bool_prefix', element: [$field => $value], queryPart: $this->query['bool']['must_not']);

        return $this;
    }

    public function whereBoolFilterMatch(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('filter', $this->query['bool']);
        $this->addElement('match', element: [$field => $value], queryPart: $this->query['bool']['filter']);

        return $this;
    }

    public function whereBoolFilterPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('filter', $this->query['bool']);
        $this->addElement('prefix', element: [$field => $value], queryPart: $this->query['bool']['filter']);

        return $this;
    }

    public function whereBoolFilterTerm(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('filter', $this->query['bool']);
        $this->addElement('term', element: [$field => $value], queryPart: $this->query['bool']['filter']);

        return $this;
    }

    public function whereBoolFilterMatchBoolPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('filter', $this->query['bool']);
        $this->addElement('match_bool_prefix', element: [$field => $value], queryPart: $this->query['bool']['filter']);

        return $this;
    }

    public function whereBoolShouldMatch(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('should', $this->query['bool']);
        $this->addElement('match', element: [$field => $value], queryPart: $this->query['bool']['should']);

        return $this;
    }

    public function whereBoolShouldPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('should', $this->query['bool']);
        $this->addElement('prefix', element: [$field => $value], queryPart: $this->query['bool']['should']);

        return $this;
    }

    public function whereBoolShouldTerm(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('should', $this->query['bool']);
        $this->addElement('term', element: [$field => $value], queryPart: $this->query['bool']['should']);

        return $this;
    }

    public function whereBoolShouldMatchBoolPrefix(string $field, mixed $value): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('should', $this->query['bool']);
        $this->addElement('match_bool_prefix', element: [$field => $value], queryPart: $this->query['bool']['should']);

        return $this;
    }

    public function whereMatch(string $field, mixed $value): self
    {
        $this->addElement('match', element: [$field => $value], queryPart: $this->query);

        return $this;
    }

    public function wherePrefix(string $field, mixed $value): self
    {
        $this->addElement('prefix', element: [$field => $value], queryPart: $this->query);

        return $this;
    }

    public function whereTerm(string $field, mixed $value): self
    {
        $this->addElement('term', element: [$field => $value], queryPart: $this->query);

        return $this;
    }

    public function whereMatchBoolPrefix(string $field, mixed $value): self
    {
        $this->addElement('match_bool_prefix', element: [$field => $value], queryPart: $this->query);

        return $this;
    }

    public function whereNested(string $path, Builder $builder): self
    {
        $this->addElement('nested', element: [
            'path' => $path,
            'query' => $builder->rawQuery()
        ], queryPart: $this->query);

        return $this;
    }

    public function whereBoolMustNested(string $path, Builder $builder): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('must', $this->query['bool']);
        $this->addElement('nested', element: [
            'path' => $path,
            'query' => $builder->rawQuery()
        ], queryPart: $this->query['bool']['must']);

        return $this;
    }

    public function whereBoolShouldNested(string $path, Builder $builder): self
    {
        $this->addKeyIfNotExists('bool', $this->query);
        $this->addKeyIfNotExists('should', $this->query['bool']);
        $this->addElement('nested', element: [
            'path' => $path,
            'query' => $builder->rawQuery()
        ], queryPart: $this->query['bool']['should']);

        return $this;
    }

    public function size(int $size = Pagination::DEFAULT_SIZE, string $scroll='5m'): self
    {
        $this->params['size'] = $size;
        $this->params['scroll'] = $scroll;

        return $this;
    }

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function sort(
        string $field,
        string $order = Pagination::DEFAULT_SORT_ORDER,
        string $mode = Pagination::DEFAULT_SORT_MODE,
        string $format = Pagination::DEFAULT_SORT_FORMAT
    ): self {
        $this->addKeyIfNotExists('sort', $this->params['body']);

        $element = ['order' => $order];
        if($mode !== '') {
            $element['mode'] = $mode;
        }
        if($format !== '') {
            $element['format'] = $format;
        }

        $this->addElement($field, $element, $this->params['body']['sort']);

        return $this;
    }

    public function rawQuery(): array
    {
        return $this->query;
    }

    public function rawParams(): array
    {
        $this->params['body']['query'] = $this->query;

        return $this->params;
    }

    public function search(): Collection|LengthAwarePaginator
    {
        $this->params['body']['query'] = $this->query;

        return $this->search->rawSearch($this->params, $this->page);
    }

    private function addKeyIfNotExists(string $key, array &$queryPart): void
    {
        if(!array_key_exists($key, $queryPart)) {
            $queryPart[$key] = [];
        }
    }

    private function addElement(string $key, array $element, array &$queryPart): void
    {
        $queryPart[] = [
            $key => $element,
        ];
    }
}
