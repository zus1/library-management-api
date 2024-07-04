<?php

namespace App\Interface;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ImageOwnerInterface
{
    public function images(): MorphMany;
}
