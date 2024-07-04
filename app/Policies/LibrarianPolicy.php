<?php

namespace App\Policies;

use App\Const\Role;
use App\Models\Librarian;

class LibrarianPolicy
{
    public function pass(Librarian $user): bool
    {
        return $user->hasRole(Role::ADMIN);
    }
}
