<?php

namespace App\Observers\ElasticSearch;

use App\Models\Author;
use App\Models\Book;

class AuthorElasticObserver extends BaseElasticObserver
{
    public function updated(Author $model): void
    {
        $books = $model->books()->with('author')->get();

        /** @var Book $book */
        foreach ($books as $book) {
            $updated = $this->elasticSearch->update('book', $book->toArray(), $book->id);

            $this->log($updated, $book->id, index: 'book', action: __FUNCTION__);
        }
    }

    public function deleting(Author $model): void
    {
        $this->removeBooks($model);
    }

    private function removeBooks(Author $model): void
    {
        $books = $model->books()->get();

        /** @var Book $book */
        foreach ($books as $book) {
            $this->remove($book->id, 'book');
        }
    }

    private function remove(int $id, string $index): void
    {
        $deleted = $this->elasticSearch->remove($index, $id);

        $this->log($deleted, $id, index: $index, action: __FUNCTION__.'ed');
    }
}
