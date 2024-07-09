<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property float $amount
 * @property string $status
 */
#[Attributes([
    ['id', 'fine:collection'],
    ['amount', 'fine:collection', 'fine:nestedClientRetrieve'],
    ['status', 'fine:collection', 'fine:changeStatus'],
    ['client', 'fine:collection'],
    ['book', 'fine:collection', 'fine:nestedClientRetrieve'],
])]
class Fine extends Model
{
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
