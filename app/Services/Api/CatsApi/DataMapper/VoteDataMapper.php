<?php

namespace App\Services\Api\CatsApi\DataMapper;

use App\Services\Api\CatsApi\Dto\VoteDto;
use Zus1\Api\Dto\ApiModel;
use Zus1\Api\Interface\DataMapperInterface;

class VoteDataMapper implements DataMapperInterface
{

    public function map(array $data): ApiModel
    {
        return VoteDto::create([
            'image_id' => $data['image_id'],
            'vote' => $data['value']
        ]);
    }
}
