<?php

namespace App\Models;

use App\Interface\CanBeActiveInterface;
use Iksaku\Laravel\MassUpdate\MassUpdatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property int $id
 * @property string $created_at
 * @property string $expires_at
 * @property bool $active
 * @property int $extended_times
 * @property bool $overdue_warning_sent
 * @property int $client_id
 * @property Client $client
 * @property Book $book
 * @method static massUpdate(array $objects)
 */
#[Attributes([
    ['id', 'rental:create', 'rental:retrieve', 'rental:collection', 'rental:nestedClientRetrieve'],
    ['created_at', 'rental:create', 'rental:extend', 'rental:retrieve', 'rental:collection'],
    ['expires_at', 'rental:create', 'rental:extend', 'rental:retrieve', 'rental:collection', 'rental:nestedClientRetrieve'],
    ['active', 'rental:create', 'rental:toggleActive', 'rental:retrieve', 'rental:collection'],
    ['client', 'rental:create', 'rental:retrieve', 'rental:collection'],
    ['book', 'rental:create', 'rental:retrieve', 'rental:collection', 'rental:nestedClientRetrieve'],
])]
class Rental extends Model implements CanBeActiveInterface
{
    use HasFactory, MassUpdatable;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function clientLibraryCard(): HasOneThrough
    {
        return $this->hasOneThrough(
            LibraryCard::class,
            Client::class,
            'id',
            'client_id',
            'client_id',
            'id',
        );
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'overdue_warning_sent' => 'boolean',
        ];
    }
}
