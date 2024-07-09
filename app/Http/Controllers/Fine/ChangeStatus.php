<?php

namespace App\Http\Controllers\Fine;

use App\Http\Requests\FineRequest;
use App\Models\Fine;
use App\Repository\FineRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class ChangeStatus
{
    public function __construct(
        private FineRepository $repository,
    ){
    }

    public function __invoke(FineRequest $request, Fine $fine): JsonResponse
    {
        $fine = $this->repository->changeStatus($fine, (string)$request->query('status'));

        return new JsonResponse(Serializer::normalize($fine, 'fine:changeStatus'));
    }
}
