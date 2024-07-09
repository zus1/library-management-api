<?php

namespace App\Repository;

use App\Interface\ImageOwnerInterface;
use App\Listeners\AwsSignListener;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class ImageRepository extends LaravelBaseRepository
{
    protected const MODEL = Image::class;

    public function create(string $filename, string $size, ImageOwnerInterface $owner): Image
    {
        $image = new Image();
        $image->image = $filename;
        $image->type = $size;

        if($owner instanceof Model) {
            $image->imageOwner()->associate($owner);
        }

        $image->save();

        return $image;
    }

    public function deleteAll(ImageOwnerInterface $owner): Collection
    {
        AwsSignListener::disable();
        $images = $owner->images()->get();
        AwsSignListener::enable();

        $owner->images()->delete();

        return $images;
    }
}
