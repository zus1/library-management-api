<?php

namespace App\Const;

use Symfony\Component\HttpKernel\Exception\HttpException;

class LibraryCardType extends Constant
{
    public final const FAMILY = 'family';
    public final const INDIVIDUAL = 'individual';

    public static function getRentalDuration(string $type): int
    {
        return match ($type) {
            self::FAMILY => 30,
            self::INDIVIDUAL => 15,
            default => self::throwException($type),
        };
    }

    public static function allowedNumberOfRentals(string $type): int
    {
        return match ($type) {
            self::FAMILY => 8,
            self::INDIVIDUAL => 4,
            default => self::throwException($type),
        };
    }

    public static function maxNumberOfExtensions(string $type): int
    {
        return match ($type) {
            self::FAMILY => 3,
            self::INDIVIDUAL => 2,
            default => self::throwException($type),
        };
    }

    private static function throwException(string $type)
    {
        throw new HttpException(500, 'Unknown library card Type '.$type);
    }
}
