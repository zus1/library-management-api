<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property string $name
 * @property string $dob
 * @property string $nationality
 */
#[Attributes([
    ['id', 'author:create', 'author:retrieve', 'author:collection', 'author:nestedBookCreate', 'author:nestedBookRetrieve'],
    ['name',
        'author:create', 'author:update', 'author:retrieve',
        'author:collection', 'author:nestedBookCreate', 'author:nestedBookRetrieve', 'author:nestedBookCollection'
    ],
    ['dob', 'author:create', 'author:update', 'author:retrieve', 'author:collection'],
    ['nationality', 'author:create', 'author:update', 'author:retrieve', 'author:collection'],
    ['books', 'author:create', 'author:retrieve'],
])]
class Author extends Model
{
    use HasFactory;

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function booksNum(): int
    {
        return $this->hasMany(Book::class)->count();
    }
}
