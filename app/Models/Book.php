<?php

namespace App\Models;

use App\Interface\ImageOwnerInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property string $dimensions
 * @property int $num_of_pages
 * @property string $cover_type
 * @property string $year_of_release
 * @property int $edition
 * @property string $genre
 * @property string $type
 * @property int $author_id
 */
#[Attributes([
    ['id',
        'book:nestedAuthorCreate', 'book:nestedAuthorRetrieve', 'book:create',
        'book:retrieve', 'book:collection', 'imageOwner:nestedImageUpload',
        'book:nestedRentalCreate', 'book:nestedRentalRetrieve', 'client:nestedFineCollection',
        'book:nestedClientRetrieve'
    ],
    ['title',
        'book:nestedAuthorRetrieve', 'book:create', 'book:nestedAuthorCreate',
        'book:update', 'book:retrieve', 'book:collection', 'book:nestedRentalCreate',
        'book:nestedRentalRetrieve', 'rental:collection', 'client:nestedFineCollection',
        'book:nestedClientRetrieve'
    ],
    ['isbn', 'book:create', 'book:update', 'book:retrieve', 'book:collection'],
    ['genre', 'book:create', 'book:update', 'book:retrieve', 'book:collection'],
    ['type', 'book:create', 'book:update', 'book:retrieve'],
    ['num_of_pages', 'book:create', 'book:update', 'book:retrieve'],
    ['cover_type', 'book:create', 'book:update', 'book:retrieve'],
    ['year_of_release', 'book:create', 'book:update', 'book:retrieve'],
    ['edition', 'book:create', 'book:update', 'book:retrieve'],
    ['dimensions', 'book:create', 'book:update', 'book:retrieve'],
    ['author', 'book:create', 'book:retrieve', 'book:collection'],
    ['images', 'book:retrieve'],
])]
class Book extends Model implements ImageOwnerInterface
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'year_of_release',
        'dimensions',
        'num_of_pages',
        'cover_type',
        'edition',
        'genre',
        'type',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'image_owner');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
