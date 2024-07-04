<?php

namespace App\Http\Controllers\Librarian;

use App\Const\Role;
use App\Repository\LibrarianRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Zus1\LaravelBaseRepository\Controllers\BaseCollectionController;
use Zus1\Serializer\Facade\Serializer;

class RetrieveCollection extends BaseCollectionController
{
    public function __construct(LibrarianRepository $repository)
    {
        parent::__construct($repository);
    }

    public function __invoke(Request $request): JsonResponse
    {
        if($request->input('query')) {
            $filters = $request->query('filters');
            $filters['roles'] = Role::LIBRARIAN;
            $request->query->replace(['filters' => $filters]);
        } else {
            $request->query->add(['filters' => ['roles' => Role::LIBRARIAN]]);
        }

        $librarians = $this->retrieveCollection($request);

        return new JsonResponse(Serializer::normalize($librarians, 'librarian:collection'));
    }
}
