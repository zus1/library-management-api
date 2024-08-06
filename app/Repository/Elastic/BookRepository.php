<?php

namespace App\Repository\Elastic;

use Zus1\Elasticsearch\Repository\BaseElasticRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository extends BaseElasticRepository
{
    protected const INDEX = 'book';

    public function search(string $query, int $page, int $size): LengthAwarePaginator
    {
        return $this->getBuilder()
            ->whereBoolShouldMatch('title', $query)
            ->whereBoolShouldNested('author', $this->getBuilder()
                ->whereBoolShouldMatch('author.name', $query)
            )->page($page)
            ->size($size)
            ->search();
    }

    public function autocomplete(string $query, int $size): Collection
    {
        return $this->getBuilder()
            ->whereBoolShouldMatchBoolPrefix('title', $query)
            ->whereBoolShouldNested('author', $this->getBuilder()
                ->whereMatchBoolPrefix('author.name', $query)
            )->size($size)
            ->search();
    }
}
