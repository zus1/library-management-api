<?php

namespace App\Repository;

use App\Interface\ImageOwnerInterface;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class ImageRepository extends LaravelBaseRepository
{
    protected const MODEL = Image::class;

    public function create(string $filename, string $type, ImageOwnerInterface $owner): Image
    {
        $image = new Image();
        $image->image = $filename;
        $image->type = $type;

        $image->imageOwner()->associate($owner);

        $image->save();

        return $image;
    }

    public function deleteAll(ImageOwnerInterface $owner): Collection
    {
        $images = $owner->images()->get();

        $owner->images()->delete();

        return $images;
    }
}
