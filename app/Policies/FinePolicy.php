<?php

namespace App\Policies;

use App\Const\Role;

class FinePolicy extends PassablePolicy
{
    protected const ROLE = Role::LIBRARIAN;
}
