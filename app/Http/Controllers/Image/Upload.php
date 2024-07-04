<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\UploadRequest;
use App\Interface\ImageOwnerInterface;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Zus1\Serializer\Facade\Serializer;

class Upload
{
    public function __construct(
        private UploadService $uploadService,
    ){
    }

    public function __invoke(UploadRequest $request, ?ImageOwnerInterface $owner = null): JsonResponse
    {
        /** @var ImageOwnerInterface $owner $owner */
        $owner = $owner ?? Auth::user();
        $image = $request->file('image');

        $collection = $this->uploadService->upload($image, $owner);

        return new JsonResponse(Serializer::normalize($collection, ['image:upload', 'imageOwner:nestedImageUpload']));
    }
}
