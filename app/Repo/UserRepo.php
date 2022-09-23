<?php

namespace App\Repo;

use App\Interfaces\UserRepoInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepo implements UserRepoInterface
{
    public function create($firstName, $lastName, $userName, $password)
    {
        return User::create([
            'firstname' => $firstName,
            'lastname' => $lastName,
            'username' => $userName,
            'password' => Hash::make($password),
        ]);
    }

    public function alluser()
    {
        return User::get(['id', 'username']);
    }

    public function user()
    {
        return auth()->guard('users')->user();
    }
}
