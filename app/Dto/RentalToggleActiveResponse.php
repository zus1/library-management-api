<?php

namespace App\Dto;

use App\Models\Client;
use App\Models\Fine;
use App\Models\Rental;
use Zus1\Serializer\Facade\Serializer;

class RentalToggleActiveResponse implements \JsonSerializable
{
    private array $rental;
    private float $fineAmount;
    private float $totalFineAmount;

    public static function create(Rental $rental, ?Fine $fine = null): self

    {
        /** @var Client $client */
        $client = $rental->client()->first();

        $instance = new self();

        $instance->rental = Serializer::normalize($rental, 'rental:toggleActive');
        $instance->totalFineAmount = $client->pendingFinesAmount();
        $instance->fineAmount = $fine !== null ? $fine->amount : 0.00;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
