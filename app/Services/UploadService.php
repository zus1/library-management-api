<?php

namespace App\Services;

use App\Const\ImageType;
use App\Interface\ImageOwnerInterface;
use App\Repository\ImageRepository;
use App\Services\Aws\S3;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class UploadService
{
    public function __construct(
        private S3 $s3,
        private ImageRepository $repository
    ){
    }

    public function upload(UploadedFile $image, ImageOwnerInterface $owner): Collection
    {
        $this->deleteOld($owner);

        $imageProcessor = Image::read($image->getRealPath());
        $imagesCollection = new Collection();

        foreach (ImageType::getValues() as $imageType) {
            $filePath = $this->resizeImage($imageProcessor, $imageType);

            $filename = $this->makeFilename($image, $owner, $imageType);

            $this->save($imagesCollection, $owner, $filename, $imageType, $filePath);
        }

        return $imagesCollection;
    }

    public function deleteOld(ImageOwnerInterface $owner): array
    {
        $deletedImages = $this->repository->deleteAll($owner);

        if($deletedImages->isEmpty() === true) {
            return [
                'db' => null,
                'cloud' => null,
            ];
        }

        $filenames = array_map(function (\App\Models\Image $image) {
            return $image->image;
        }, $deletedImages->all());

        $deleted = $this->s3->deleteMany($filenames);

        return [
            'db' => $deletedImages->count() > 0,
            'cloud' => $deleted,
        ];
    }

    private function resizeImage(ImageInterface $imageProcessor, string $imageType): string
    {
        $dimension = ImageType::dimensions($imageType);
        $imageProcessor->resize($dimension['width'], $dimension['height']);
        $imageProcessor->save($savedFile = tempnam(sys_get_temp_dir(), $imageType));

        return $savedFile;
    }

    private function makeFilename(UploadedFile $image, ImageOwnerInterface $owner, string $imageType): string
    {
        return sprintf(
            '%s/%s_%s.%s',
            $this->getPrefix($owner),
            random_int(10000, 99999), $imageType, $image->extension()
        );
    }

    private function save(
        Collection $collection,
        ImageOwnerInterface $owner,
        string $filename,
        string $imageType,
        string $filePath
    ): void {
        $this->s3->put($filename, $filePath);

        $collection->add($this->repository->create($filename, $imageType, $owner));
    }

    private function getPrefix(ImageOwnerInterface $owner): string
    {
        $ownerClassParts = explode('\\', $owner::class);

        return lcfirst(Str::plural($ownerClassParts[count($ownerClassParts)-1]));
    }
}
