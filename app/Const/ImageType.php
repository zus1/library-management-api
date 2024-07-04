<?php

namespace App\Const;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ImageType extends Constant
{
    public final const SMALL = 'small';
    public final const LARGE = 'large';

    public const RATIO = 1;

    public static function dimensions(string $type): array
    {
        return match ($type) {
            self::SMALL => [
                'width' => $width = 200,
                'height' => self::getHeight($width),
            ],
            self::LARGE => [
                'width' => $width = 600,
                'height' => self::getHeight($width)
            ],
            default => throw new HttpException(500, 'Unknown image type '.$type)
        };
    }

    private static function getHeight(int $with): int

    {
        return $with + self::RATIO;
    }
}
