<?php

namespace App\Services\Api\CatsApi\Dto;

use Zus1\Api\Dto\ApiModel;

class ImageDto extends ApiModel
{
    protected string $id;
    protected string $url;

    public static function create(array $data): self
    {
        $instance = new self();
        $instance->id = $data['id'];
        $instance->url = $data['url'];

        return $instance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
