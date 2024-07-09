<?php

namespace App\Http\Controllers\Rental;

use App\Dto\RentalToggleActiveResponse;
use App\Models\Rental;
use App\Repository\FineRepository;
use App\Repository\RentalRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToggleActive
{
    public function __construct(
        private RentalRepository  $repository,
        private FineRepository $fineRepository
    ){
    }

    public function __invoke(Request $request, Rental $rental): JsonResponse
    {
        $active = $request->query('active') === 'true';

        $this->repository->toggleActive($rental, $active);

        if($active === false) {
            $fine = $this->fineRepository->create($rental);
        }

        return new JsonResponse(RentalToggleActiveResponse::create($rental, $fine ?? null));
    }
}
