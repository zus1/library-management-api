<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property string $created_at
 * @property string $expires_at
 * @property int $card_number
 * @property string $type
 * @property int $active
 */
#[Attributes([
    ['id', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientRetrieve'],
    ['created_at', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientRetrieve'],
    ['expires_at', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientRetrieve'],
    ['card_number', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientCollection', 'libraryCard:nestedClientRetrieve'],
    ['type', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientRetrieve'],
    ['active', 'libraryCard:nestedClientCreate', 'libraryCard:nestedClientRetrieve'],
])]
class LibraryCard extends Model
{
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
