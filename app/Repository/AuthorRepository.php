<?php

namespace App\Repository;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class AuthorRepository extends LaravelBaseRepository
{
    public function _construct(){
    }

    protected const MODEL = Author::class;

    public function create($data): Author
    {
        $author = new Author();
        $this->setSharedData($data, $author);

        $author->save();

        if(isset($data['books'])) {
            $author->books()->createMany($data['books']);
        }

        return $author;
    }

    public function update(array $data, Author $author): Author
    {
        $this->setSharedData($data, $author);

        $author->save();

        return $author;
    }

    public function findByIds(array $ids): Collection
    {
        $builder = $this->getBuilder();

        return $builder->whereIn('id', $ids)->get();
    }

    public function deleteIfOrphan(Author $author): void
    {
        $totalBooks = $author->booksNum();

        if($totalBooks === 0) {
            $author->delete();
        }
    }

    private function setSharedData(array $data, Author $author): void
    {
        $author->name = $data['name'];
        $author->dob = $data['dob'];
        $author->nationality = $data['nationality'];
    }
}
