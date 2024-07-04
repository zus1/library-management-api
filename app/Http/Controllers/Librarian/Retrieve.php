<?php

namespace App\Http\Controllers\Librarian;

use App\Const\Role;
use App\Models\Librarian;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zus1\Serializer\Facade\Serializer;

class Retrieve
{
    public function __invoke(Librarian $librarian): JsonResponse
    {
        if($librarian->hasRole(Role::ADMIN)) {
            throw new HttpException(400, 'Invalid user requested');
        }

        return new JsonResponse(Serializer::normalize($librarian, ['librarian:retrieve', 'image:nestedLibrarianRetrieve']));
    }
}
