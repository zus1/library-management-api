<?php

namespace App\Models;

use App\Const\FineStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Zus1\Discriminator\Observers\DiscriminatorObserver;
use Zus1\Serializer\Attributes\Attributes;

/**
 * @property array $preferences
 * @property string $phone_number
 */
#[Attributes([
    ['id',
        'client:create', 'client:collection', 'client:retrieve',
        'client:nestedRentalCreate', 'client:nestedRentalRetrieve', 'client:nestedFineCollection'
    ],
    ['preferences', 'client:create', 'client:update', 'client:retrieve'],
    ['first_name',
        'client:create', 'client:update', 'client:collection', 'client:retrieve',
        'client:nestedRentalCreate', 'client:nestedRentalRetrieve', 'rental:collection', 'client:nestedFineCollection'
    ],
    ['last_name',
        'client:create', 'client:update', 'client:collection', 'client:retrieve',
        'client:nestedRentalCreate', 'client:nestedRentalRetrieve', 'rental:collection', 'client:nestedFineCollection'
    ],
    ['dob', 'client:create', 'client:update', 'client:retrieve'],
    ['city', 'client:create', 'client:update', 'client:retrieve'],
    ['libraryCard', 'client:create', 'client:collection', 'client:retrieve'],
    ['phone_number', 'client:create', 'client:retrieve'],
    ['pendingFines', 'client:retrieve'],
    ['activeRentals', 'client:retrieve'],
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

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRentals(): HasMany
    {
        return $this->rentals()->where('active', true);
    }

    public function activeRentalsCount(): int
    {
        return $this->activeRentals()->count();
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function pendingFines(): HasMany
    {
        return $this->fines()->where('status', FineStatus::PENDING_PAYMENT);
    }

    public function pendingFinesCount(): int
    {
        return $this->pendingFines()->count();
    }

    public function pendingFinesAmount(): float
    {
        return $this->pendingFines()->sum('amount');
    }
}
