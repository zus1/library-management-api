<?php

namespace App\Http\Controllers\Rental;

use App\Http\Requests\RentalRequest;
use App\Models\Rental;
use App\Repository\RentalRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Extend
{
    public function __construct(
        private RentalRepository $repository,
    ){
    }

    public function __invoke(RentalRequest $request, Rental $rental): JsonResponse
    {
        $rental = $this->repository->extend($rental);

        return new JsonResponse(Serializer::normalize($rental, 'rental:extend'));
    }
}
