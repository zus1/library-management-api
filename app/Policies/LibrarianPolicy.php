<?php

namespace App\Policies;

use App\Const\Role;

class LibrarianPolicy extends PassablePolicy
{
    public const ROLE = Role::ADMIN;
}
