<?php

namespace App\Const;

abstract class Constant
{
    public static function getValues(): array
    {
        $rf = new \ReflectionClass(static::class);

        return array_values($rf->getConstants(\ReflectionClassConstant::IS_FINAL));
    }
}
