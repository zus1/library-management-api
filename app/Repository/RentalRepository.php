<?php

namespace App\Repository;

use App\Const\LibraryCardType;
use App\Models\Book;
use App\Models\Client;
use App\Models\LibraryCard;
use App\Models\Rental;
use App\Trait\ModelCanBeActive;
use Carbon\Carbon;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class RentalRepository extends LaravelBaseRepository
{
    use ModelCanBeActive;

    public const MODEL = Rental::class;

    public function create(Client $client, Book $book): Rental
    {
        /** @var LibraryCard $libraryCard */
        $libraryCard = $client->libraryCard()->first();

        $rental = new Rental();
        $rental->created_at = Carbon::now();
        $rental->expires_at = Carbon::now()->addDays(LibraryCardType::getRentalDuration($libraryCard->type))->format('Y-m-d H:i:s');
        $rental->active = true;

        $rental->client()->associate($client);
        $rental->book()->associate($book);

        $rental->save();

        return $rental;
    }

    public function extend(Rental $rental): Rental
    {
        /** @var LibraryCard $libraryCard */
        $libraryCard = $rental->clientLibraryCard()->first();

        $rental->expires_at = (new Carbon($rental->expires_at))->addDays(LibraryCardType::getRentalDuration($libraryCard->type))
            ->format('Y-m-d H:i:s');
        $rental->extended_times++;

        $rental->save();

        return $rental;
    }

    public function handleExpiredRentals(int $chunkSize, array $callback): void
    {
        $builder = $this->getBuilder();

        $builder->where('active', true)
            ->where('expires_at', '<=', Carbon::now()->startOfHour()->format('Y-m-d H:i:s'))
            ->where('overdue_warning_sent', false)
            ->with('client')
            ->with('book')
            ->chunkById($chunkSize, $callback);
    }
}
