<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Requests\LibrarianRequest;
use App\Models\Librarian;
use App\Repository\LibrarianRepository;
use Illuminate\Http\JsonResponse;
use Zus1\Serializer\Facade\Serializer;

class ToggleActive
{
    public function __construct(
        private LibrarianRepository $repository,
    ){
    }

    public function __invoke(LibrarianRequest $request, Librarian $librarian): JsonResponse
    {
        $active = $request->query('active') === 'true';

        $librarian = $this->repository->toggleActive($librarian, $active);

        return new JsonResponse(Serializer::normalize($librarian, 'librarian:toggleActive'));
    }
}
