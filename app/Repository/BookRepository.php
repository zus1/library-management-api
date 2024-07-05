<?php

namespace App\Repository;

use App\Models\Author;
use App\Models\Book;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class BookRepository extends LaravelBaseRepository
{
    public function __construct(
        private AuthorRepository $authorRepository,
    ){
    }

    public const MODEL = Book::class;

    public function create(array $data): Book
    {
        $book = new Book();
        $book->isbn = $data['isbn'];
        $this->setSharedData($data, $book);

        $this->associateAuthor($data['author'], $book);

        $book->save();

        return $book;
    }

    public function update(array $data, Book $book): Book
    {
        $this->setSharedData($data, $book);

        $book->save();

        return $book;
    }

    public function delete(Book $book): void
    {
        /** @var Author $author */
        $author = $book->author()->first();

        $book->delete();

        $this->authorRepository->deleteIfOrphan($author);
    }

    private function associateAuthor(array $data, Book $book): void
    {
        if(isset($data['id'])) {
            /** @var Author $author */
            $author = $this->authorRepository->findOneByOr404(['id' => $data['id']]);

            $book->author()->associate($author);

            return;
        }

        $author = $this->authorRepository->create($data);

        $book->author()->associate($author);
    }

    private function setSharedData(array $data, Book $book): void
    {
        $book->title = $data['title'];
        $book->dimensions = $data['dimensions'];
        $book->num_of_pages = $data['num_of_pages'];
        $book->cover_type = $data['cover_type'];
        $book->year_of_release = $data['year_of_release'];
        $book->edition = $data['edition'];
        $book->genre = $data['genre'];
        $book->type = $data['type'];
    }
}
