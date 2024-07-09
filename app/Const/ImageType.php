<?php

namespace App\Const;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ImageType extends Constant
{
    public final const LIBRARIAN = 'librarian';
    public final const BOOK = 'book';

    public static function getRatio(string $type): float
    {
        return match ($type) {
            self::LIBRARIAN => 1,
            self::BOOK => 1.5,
            default => throw new HttpException(500,
                sprintf('Unknown ratio of type %s. Did you forget to add it to class '.self::class, $type)),
        };
    }

    public static function isValid(?string $type): bool
    {
        return in_array($type, self::getValues());
    }
}
