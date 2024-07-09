<?php

namespace App\Repository;

use App\Const\FineStatus;
use App\Models\Fine;
use App\Models\Rental;
use Carbon\Carbon;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class FineRepository extends LaravelBaseRepository
{
    protected const MODEL = Fine::class;

    public function create(Rental $rental): ?Fine
    {
        if($this->getNumOfPassedDays($rental) <= 0) {
            return null;
        }

        $fine = new Fine();
        $fine->amount = $this->calculateFine($rental);
        $fine->status = FineStatus::PENDING_PAYMENT;

        $fine->client()->associate($rental->client()->first());
        $fine->book()->associate($rental->book()->first());

        $fine->save();

        return $fine;
    }

    public function changeStatus(Fine $fine, string $status): Fine
    {
        $fine->status = $status;

        $fine->save();

        return $fine;
    }

    private function calculateFine(Rental $rental): float
    {
        return $this->getNumOfPassedDays($rental) * config('app.fine.amount');
    }

    private function getNumOfPassedDays(Rental $rental): int
    {
        return floor((new Carbon($rental->expires_at))->diffInDays(Carbon::now()));
    }
}
