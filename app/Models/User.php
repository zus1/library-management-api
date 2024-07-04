<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zus1\Discriminator\Trait\Discriminator;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $city
 */
class User extends Authenticatable
{
    use HasFactory, Discriminator;
}
