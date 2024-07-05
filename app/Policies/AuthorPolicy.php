<?php

namespace App\Policies;

use App\Const\Role;
use App\Models\Librarian;

class AuthorPolicy extends PassablePolicy
{
    public const ROLE = Role::LIBRARIAN;
}
