<?php

namespace App\Repository;

use App\Models\LibraryCard;
use Carbon\Carbon;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class LibraryCardRepository extends LaravelBaseRepository
{
    private const CARD_DURATION = 365;

    public const MODEL = LibraryCard::class;

    public function create(array $data): LibraryCard
    {
        $libraryCard = new LibraryCard();
        $libraryCard->created_at = Carbon::now();
        $libraryCard->expires_at = Carbon::now()->addDays(self::CARD_DURATION);
        $libraryCard->card_number = random_int(100000000, 999999999);
        $libraryCard->type = $data['type'];
        $libraryCard->active = true;

        return $libraryCard;
    }
}
