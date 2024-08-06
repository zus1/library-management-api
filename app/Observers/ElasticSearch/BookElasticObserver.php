<?php

namespace App\Observers\ElasticSearch;

use App\Models\Author;
use App\Models\Book;

class BookElasticObserver extends BaseElasticObserver
{
    public function created(Book $model): void
    {
        /** @var Author $author */
        $author = $model->author()->first();

        $added = $this->elasticSearch->add('book', $model->toArray(), $model->id, nested: ['author' => [$author->toArray()]]);

        $this->log($added, $model->id, 'book', __FUNCTION__);
    }

    public function updated(Book $model): void
    {
        $updated = $this->elasticSearch->update('book', $model->toArray(), $model->id);

        $this->log($updated, $model->id, 'book', __FUNCTION__);
    }

    public function deleted(Book $model): void
    {
        $removed = $this->elasticSearch->remove('book', $model->id);

        $this->log($removed, $model->id, 'book', __FUNCTION__);
    }
}
