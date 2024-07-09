<?php

namespace App\Http\Controllers\Rental;

use App\Http\Requests\RentalRequest;
use App\Models\Book;
use App\Models\Client;
use App\Repository\RentalRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class Create
{
    public function __construct(
        private RentalRepository $repository,
    ){
    }

    public function __invoke(RentalRequest $request, Client $client, Book $book): JsonResponse
    {
        $rental = $this->repository->create($client, $book);

        return new JsonResponse(Serializer::normalize($rental,
            ['rental:create', 'client:nestedRentalCreate', 'book:nestedRentalCreate']));
    }
}
