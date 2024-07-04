<?php

namespace App\Http\Controllers\Image;

use App\Interface\ImageOwnerInterface;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;

class Delete
{
    public function __construct(
        private UploadService $uploadService
    ){
    }

    public function __invoke(ImageOwnerInterface $owner): JsonResponse
    {
        $deleted = $this->uploadService->deleteOld($owner);

        return new JsonResponse($deleted);
    }
}
