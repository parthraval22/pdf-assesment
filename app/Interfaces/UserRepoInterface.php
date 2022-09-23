<?php

namespace App\Interfaces;

interface UserRepoInterface
{
    public function create($firstName, $lastName, $userName, $password);
    public function alluser();
    public function user();
}
