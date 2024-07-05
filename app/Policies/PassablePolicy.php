<?php

namespace App\Policies;

use App\Models\Librarian;

abstract class PassablePolicy
{
    protected const ROLE = '';

    public function pass(Librarian $user): bool
    {
        return $user->hasRole(static::ROLE);
    }
}
