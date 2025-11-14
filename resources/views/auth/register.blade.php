@extends('layouts.auth')

@section('title', 'Login')

@section('content')

     <!-- login and register-page container -->
      <main class="auth-container">
        <div class="auth-card">

            <h2>Register</h2>

           <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="label-input-container">
            <div class="label-input">
            
                <label for="nickname">Nickname</label>
                 <input name="nickname" type="text" required>

            </div>
            <div class="label-input">
                <label for="email">Email</label>
                <input name="email" type="email" required>
            </div>
             <div class="label-input">
                <label for="password">Password</label>
                <input name="password" type="password" required>
                </div>
             <div class="label-input">
                <label for="password_confirmation">Password</label>
                
                <input name="password_confirmation" type="password" required>
                </div>
                </div>

                <button type="submit" class="btn">Continue</button>
            </form>

            <!-- Navigation text to register-page -->
             <p class="auth-alternative">Already have an account? <a href="{{ route('login') }}" class="other-auth-option-a">Login</a></p>
        </div>
</main>
@endsection
