<?php

namespace App\Services\Api\CatsApi\Dto;

use Zus1\Api\Dto\ApiModel;

class VoteDto extends ApiModel
{
    protected string $imageId;
    protected int $vote;

    public static function create(array $data): self
    {
        $instance = new self();
        $instance->imageId = $data['image_id'];
        $instance->vote = $data['vote'];

        return $instance;
    }

    public function getVote(): int
    {
        return $this->vote;
    }

    public function getImageId(): string
    {
        return $this->imageId;
    }
}
