<?php

namespace App\Http\Controllers\Fine;

use App\Repository\FineRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Zus1\LaravelBaseRepository\Controllers\BaseCollectionController;
use Zus1\Serializer\Facade\Serializer;

class RetrieveCollection extends BaseCollectionController
{
    public function __construct(FineRepository $repository)
    {
        parent::__construct($repository);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $collection = $this->retrieveCollection($request);

        return new JsonResponse(Serializer::normalize($collection,
            ['fine:collection', 'book:nestedFineCollection', 'client:nestedFineCollection']));
    }
}
