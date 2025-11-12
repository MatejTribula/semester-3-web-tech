<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate form inputs
        $request->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed', // requires password_confirmation field
        ]);

        // Create user with hashed password
        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log in the user immediately
        Auth::login($user);

        // Return success response
        return response()->json([
            'message' => 'User registered and logged in successfully',
            'user' => $user,
        ], 201);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // // Login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => auth()->user(),
        ]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
