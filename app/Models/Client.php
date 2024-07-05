<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Zus1\Discriminator\Observers\DiscriminatorObserver;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property array $preferences
 * @property string $phone_number
 */
#[Attributes([
    ['id', 'client:create', 'client:collection', 'client:retrieve'],
    ['preferences', 'client:create', 'client:update', 'client:retrieve'],
    ['first_name', 'client:create', 'client:update', 'client:collection', 'client:retrieve'],
    ['last_name', 'client:create', 'client:update', 'client:collection', 'client:retrieve'],
    ['dob', 'client:create', 'client:update', 'client:retrieve'],
    ['city', 'client:create', 'client:update', 'client:retrieve'],
    ['libraryCard', 'client:create', 'client:collection', 'client:retrieve'],
    ['phone_number', 'client:create', 'client:retrieve'],
])]
#[ObservedBy(DiscriminatorObserver::class)]
class Client extends User
{
    use HasFactory;

    public $timestamps = false;

    public function libraryCard(): HasOne
    {
        return $this->hasOne(LibraryCard::class);
    }
}
