<?php

namespace App\Policies;

use App\Const\Role;
use App\Models\Librarian;

class BookPolicy extends PassablePolicy
{
    public const ROLE = Role::LIBRARIAN;
}
