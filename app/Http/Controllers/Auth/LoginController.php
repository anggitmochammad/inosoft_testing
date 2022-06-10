<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            // return response($user);

            $token = $user->createToken('auth_token')->plainTextToken;
            
            $response = [
                'data' => $user,
                'success' => true,
                'token' => $token,
            ];
            return response($response, 201);
        }

        return response([
            'success'   => false,
            'message' => 'Email atau Password Salah'
        ], 404);
    }
}
