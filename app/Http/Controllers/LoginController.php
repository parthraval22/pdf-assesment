<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password'  => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('users')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return response()->json(['errors' => ['password' => ['The provided credentials do not match with our records.']]], 422);
    }

    public function logout(Request $request)
    {
        Auth::guard('users')->logout();
        return redirect('/login');
    }
}
