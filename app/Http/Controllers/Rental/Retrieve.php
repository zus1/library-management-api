<?php

namespace App\Http\Controllers\Rental;

use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Retrieve
{
    public function __invoke(Rental $rental): JsonResponse
    {
        return new JsonResponse(Serializer::normalize($rental,
            ['rental:retrieve', 'book:nestedRentalRetrieve', 'client:nestedRentalRetrieve']));
    }
}
