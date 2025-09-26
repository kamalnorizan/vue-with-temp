<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'userData' => $user,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
