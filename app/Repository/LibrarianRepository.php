<?php

namespace App\Repository;

use App\Const\Role;
use App\Models\Librarian;
use Illuminate\Support\Facades\Hash;

class LibrarianRepository extends UserRepository
{
    protected const MODEL = Librarian::class;

    public function register(array $data): Librarian
    {
        $librarian = new Librarian();
        $librarian->email = $data['email'];
        $librarian->password = Hash::make($data['password']);
        $librarian->roles = [Role::LIBRARIAN];
        $librarian->seniority = $data['seniority'];
        $librarian->social_security_number = $data['social_security_number'];
        $librarian->employed_at = $data['employed_at'];
        $librarian->identifier = random_int(1000, 9999);

        $this->setBaseData($librarian, $data);

        $librarian->save();

        return $librarian;
    }

    public function toggleActive(Librarian $librarian, bool $active): Librarian
    {
        $librarian->active = $active;

        $librarian->save();

        return $librarian;
    }
}