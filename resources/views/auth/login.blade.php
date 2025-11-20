@extends('layouts.auth')

@section('title', 'Login')

@section('content')

     <!-- login and register-page container -->
      <main class="auth-container">
        <div class="auth-card">

            <h2>Login</h2>

           <form action="{{ route('login') }}" method="POST">
            @csrf

            

            <div class="label-input-container">
                @if ($errors->any())
                <div class="auth-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="label-input">
                <label for="email">Email</label>
                <input name="email" type="email" required>
            </div>
             <div class="label-input">
                <label for="password">Password</label>

                <input name="password" type="password" required>
                </div>
                </div>

                <button type="submit" class="btn">Continue</button>
            </form>

            <!-- Navigation text to register-page -->
            <p class="auth-alternative">Don't have an account yet? <a href="{{ route('register') }}" class="other-auth-option-a">Register</a></p>
        </div>
</main>
@endsection
