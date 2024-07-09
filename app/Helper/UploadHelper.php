<?php

namespace App\Helper;

use App\Interface\ImageOwnerInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class UploadHelper
{
    public function getPrefix(ImageOwnerInterface $owner): string
    {
        $ownerClassParts = explode('\\', $owner::class);

        return lcfirst(Str::plural($ownerClassParts[count($ownerClassParts)-1]));
    }

    public function getSingularPrefix(ImageOwnerInterface $owner): string
    {
        return Str::singular($this->getPrefix($owner));
    }

    public function getRepository(string $ownerType): LaravelBaseRepository
    {
        $repositoryClass = sprintf('App\\Repository\\%sRepository', ucfirst($ownerType));

        return App::make($repositoryClass);
    }
}
