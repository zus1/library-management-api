<?php

namespace App\Const;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ImageSize extends Constant
{
    public final const SMALL = 'small';
    public final const LARGE = 'large';

    public static function dimensions(string $size, string $type): array
    {
        return match ($size) {
            self::SMALL => [
                'width' => $width = 200,
                'height' => self::getHeight($width, $type),
            ],
            self::LARGE => [
                'width' => $width = 600,
                'height' => self::getHeight($width, $type)
            ],
            default => throw new HttpException(500, 'Unknown image size '.$size)
        };
    }

    private static function getHeight(int $with, string $type): int
    {
        return $with * ImageType::getRatio($type);
    }
}
