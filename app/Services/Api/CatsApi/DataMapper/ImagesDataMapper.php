<?php

namespace App\Services\Api\CatsApi\DataMapper;

use App\Services\Api\CatsApi\Dto\ImageDto;
use Zus1\Api\Interface\DataMapperInterface;
use Illuminate\Support\Collection;

class ImagesDataMapper implements DataMapperInterface
{
    public function map(array $data): Collection
    {
        $models = [];

        array_walk($data, function (array $value) use(&$models) {
            $models[] = $this->mapToDto($value);
        });

        return new Collection($models);
    }

    private function mapToDto(array $subArray): ImageDto
    {
        return ImageDto::create([
            'id' => $subArray['id'],
            'url' => $subArray['url'],
        ]);
    }
}
