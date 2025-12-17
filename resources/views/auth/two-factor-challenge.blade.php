@extends('layouts.auth')

@section('title', 'Two-Factor Authentication')

@section('content')
<main class="auth-container">
    <div class="auth-card">
        <h2>Two-Factor Authentication</h2>
        
        <p style="margin-bottom: 1.5rem; color: #666;">
            Please enter your authentication code or recovery code to continue.
        </p>

        <form method="POST" action="{{ url('/two-factor-challenge') }}">
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
                    <label for="code">Authentication Code</label>
                    <input 
                        type="text" 
                        name="code" 
                        id="code" 
                        placeholder="000000"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        autofocus
                        style="font-size: 1.2rem; text-align: center; letter-spacing: 0.3rem;"
                    >
                </div>

                <p style="text-align: center; margin: 1rem 0; color: #999;">or</p>

                <div class="label-input">
                    <label for="recovery_code">Recovery Code</label>
                    <input 
                        type="text" 
                        name="recovery_code" 
                        id="recovery_code" 
                        placeholder="xxxx-xxxx-xxxx-xxxx"
                    >
                </div>
            </div>

            <button type="submit" class="btn">Verify</button>
        </form>

        <p class="auth-alternative">
            <a href="{{ route('login') }}" class="other-auth-option-a">Back to login</a>
        </p>
    </div>
</main>
@endsection
