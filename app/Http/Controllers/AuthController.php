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
            'enable_2fa' => 'nullable|boolean',
        ]);

        // Create user with hashed password
        $user = User::create([
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if ($request->boolean('enable_2fa')){
            $user->forceFill([
                'two_factor_secret' => encrypt(app(\Laravel\Fortify\TwoFactorAuthenticationProvider::class)->generateSecretKey()),
                'two_factor_recovery_codes' => encrypt(json_encode(app(\Laravel\Fortify\RecoveryCode::class)->generate())),
            ])->save();

            return redirect()->route('2fa.setup')->with('status', '2fa enabled');
        }

        return redirect('/products');
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
            return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
        }

        $user = auth() -> user();

        if($user->two_factor_secret){
            auth()->logout();
            $request->session()->put('login.id', $user->id);
            $request->session()->put('login.remember', $request->filled('remember'));

            return redirect()->route('two-factor.login');
        }

         return redirect('/products');

    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        auth()->logout();

         return redirect('/products');

    }

    public function show2FASetup(){
        $user = auth() -> user();

        if(!$user->two_factor_secret){
            return redirect('/products');
        }

        return view('auth.2-fa-setup');
    }

    public function confirm2FA(Request $request){
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = auth() -> user();

        $verified = app(\Laravel\Fortify\TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($user->two_factor_reset), $request->code);

        if($verified){
            $user->forceFill([
                'two_factor_confirmed_at' => now(),
            ])->save();

            return redirect('/products')->with('status', '2fa setup complete');
        }

        return back()->withErrors(['code' => 'Invalid code. Try again.']);
    }
}
