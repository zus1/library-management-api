<?php

namespace App\Models;

use App\Events\ImageLoaded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property string $image
 * @property string $type
 */
#[Attributes([
    ['id', 'image:upload'],
    ['image', 'image:upload', 'image:nestedLibrarianRetrieve'],
    ['type', 'image:upload', 'image:nestedLibrarianRetrieve'],
    ['imageOwner', 'image:upload'],
])]
class Image extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'retrieved' => ImageLoaded::class,
    ];

    public function imageOwner(): MorphTo
    {
        return $this->morphTo();
    }
}
