<?php

namespace App\Repositories;

use App\Entities\Db;
use App\Entities\User;

class UserRepository
{

    private Db $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function checkForRole(array $credentials): bool
    {
        $userData = $this->db->query(
            'SELECT id FROM users WHERE name=:name AND password=:password',
            [
                ':name' => $credentials['name'],
                ':password' => $credentials['password'],
            ],
            User::class
        );

        return !empty($userData);
    }

}
