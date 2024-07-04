<?php

namespace App\Repository;

use App\Models\User;
use Zus1\LaravelBaseRepository\Repository\LaravelBaseRepository;

class UserRepository extends LaravelBaseRepository
{
    protected const MODEL = User::class;

    protected function setBaseData(User $user, array $data): void
    {
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->dob = $data['dob'];
        $user->city = $data['city'] ?? null;
    }
}
