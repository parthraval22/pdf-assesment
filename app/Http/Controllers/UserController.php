<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Interfaces\UserRepoInterface;

class UserController extends Controller
{
    private UserRepoInterface $userRepo;

    public function __construct(UserRepoInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);
        return $this->userRepo->create(
            $request->get('firstname'),
            $request->get('lastname'),
            $request->get('username'),
            $request->get('password')
        );
    }

    public function user()
    {
        return $this->userRepo->user();
    }

}
