<?php

namespace App\Services;

use App\Const\ImageSize;
use App\Helper\UploadHelper;
use App\Interface\ImageOwnerInterface;
use App\Repository\ImageRepository;
use App\Services\Aws\S3;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;

class UploadService
{
    public function __construct(
        private S3 $s3,
        private ImageRepository $repository,
        private UploadHelper $helper,
    ){
    }

    public function upload(UploadedFile $image, ImageOwnerInterface $owner): Collection
    {
        $this->deleteOld($owner);

        $imageProcessor = Image::read($image->getRealPath());
        $imagesCollection = new Collection();

        foreach (ImageSize::getValues() as $imageSize) {
            $filePath = $this->resizeImage($imageProcessor, $owner, $imageSize);

            $filename = $this->makeFilename($image, $owner, $imageSize);

            $this->save($imagesCollection, $owner, $filename, $imageSize, $filePath);
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

    private function resizeImage(ImageInterface $imageProcessor, ImageOwnerInterface $owner, string $imageSize): string
    {
        $dimension = ImageSize::dimensions($imageSize, $this->helper->getSingularPrefix($owner));
        $imageProcessor->resize($dimension['width'], $dimension['height']);
        $imageProcessor->save($savedFile = tempnam(sys_get_temp_dir(), $imageSize));

        return $savedFile;
    }

    private function makeFilename(UploadedFile $image, ImageOwnerInterface $owner, string $imageSize): string
    {
        return sprintf(
            '%s/%s_%s.%s',
            $this->helper->getPrefix($owner),
            random_int(10000, 99999), $imageSize, $image->extension()
        );
    }

    private function save(
        Collection $collection,
        ImageOwnerInterface $owner,
        string $filename,
        string $imageSize,
        string $filePath
    ): void {
        $this->s3->put($filename, $filePath);

        $collection->add($this->repository->create($filename, $imageSize, $owner));
    }
}
