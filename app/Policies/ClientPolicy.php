<?php

namespace App\Policies;

use App\Const\Role;
use App\Models\Librarian;

class ClientPolicy extends PassablePolicy
{
    protected const ROLE = Role::LIBRARIAN;
}
