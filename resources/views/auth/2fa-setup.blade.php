@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication')

@section('content')
<div class="container" style="max-width: 600px; margin: 3rem auto;">
    <h2>Setup Two-Factor Authentication</h2>
    
    <div class="qr-code-section">
        <p><strong>Step 1:</strong> Install an authenticator app on your phone (Google Authenticator, Authy, Microsoft Authenticator, etc.)</p>
        
        <p><strong>Step 2:</strong> Scan this QR code with your app:</p>
        <div style="text-align: center; margin: 2rem 0;">
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>
        
        <h3>Recovery Codes</h3>
        <p style="color: #d9534f; font-weight: 600;">
            <i class="fa-solid fa-triangle-exclamation"></i> 
            Save these recovery codes in a safe place! You'll need them if you lose access to your authenticator app.
        </p>
        <ul class="recovery-codes-list">
            @php
                $recoveryCodes = json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true);
                if (!is_array($recoveryCodes)) {
                    $recoveryCodes = [];
                }
            @endphp
            @foreach ($recoveryCodes as $code)
                <li>{{ $code }}</li>
            @endforeach
        </ul>
    </div>

    <form method="POST" action="{{ route('2fa.confirm') }}" style="margin-top: 2rem;">
        @csrf
        
        <p><strong>Step 3:</strong> Enter the 6-digit code from your authenticator app to confirm setup:</p>
        
        <div style="margin-top: 1rem;">
            <input 
                type="text" 
                name="code" 
                id="code" 
                placeholder="000000"
                maxlength="6"
                pattern="[0-9]{6}"
                required
                autofocus
                style="width: 100%; font-size: 1.5rem; text-align: center; letter-spacing: 0.5rem; padding: 1rem; border: 2px solid var(--clr-grey); border-radius: 5px;"
            >
            @error('code')
                <span style="color: red; display: block; margin-top: 0.5rem;">{{ $message }}</span>
            @enderror
        </div>
        
        <button type="submit" style="width: 100%; margin-top: 1.5rem;">Confirm & Complete Setup</button>
    </form>
</div>
@endsection