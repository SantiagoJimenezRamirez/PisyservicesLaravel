<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function createUser($userData)
    {
        try {
            $newUser = User::create($userData);
            return $newUser;
        } catch (\Exception $e) {
            \Log::error("Error creating user: " . $e->getMessage());
            throw new \Exception('Unable to create user');
        }
    }

    public function findByUsername($username)
    {
        try {
            return User::where('username', $username)->first();
        } catch (\Exception $e) {
            \Log::error("Error finding user by username: " . $e->getMessage());
            throw new \Exception('Error finding user by username');
        }
    }
}
