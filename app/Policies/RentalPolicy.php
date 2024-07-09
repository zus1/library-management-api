<?php

namespace App\Policies;

use App\Const\Role;

class RentalPolicy extends PassablePolicy
{
    protected const ROLE = Role::LIBRARIAN;
}
