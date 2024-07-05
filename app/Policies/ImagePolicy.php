<?php

namespace App\Policies;

use App\Const\Role;
use App\Models\Librarian;

class ImagePolicy extends PassablePolicy
{
    protected const ROLE = Role::LIBRARIAN;
}
