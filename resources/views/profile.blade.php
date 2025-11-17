@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="profile-header" data-user-id="{{ $user->id }}">
    <div class="profile-pfp-name">
        <!-- Profile Picture (view mode) -->
        <img class="profile-pfp" id="profilePfp" src="{{ $user->avatar_url ?? asset('images/grey.png') }}" alt="{{ $user->nickname }}">
        
        <!-- Profile Picture Upload (edit mode - hidden) -->
        <div class="profile-pfp-upload" id="profilePfpUpload" style="display: none;">
            <img class="profile-pfp" id="profilePfpPreview" src="{{ $user->avatar_url ?? asset('images/grey.png') }}" alt="{{ $user->nickname }}">
            <input type="file" id="avatarInput" accept="image/*" style="display: none;">
            <div class="upload-overlay">
                <i class="fa-solid fa-camera"></i>
            </div>
        </div>

        <!-- Username (view mode) -->
        <p class="profile-name" id="profileName">{{ $user->nickname }}</p>
        
        <!-- Username input (edit mode - hidden) -->
        <input type="text" class="profile-name-input" id="profileNameInput" value="{{ $user->nickname }}" style="display: none;">
        
        <!-- Edit/Save buttons -->
        @auth
            @if(auth()->id() === $user->id)
                <i class="fa-solid fa-pen" id="editToggle" style="cursor: pointer;"></i>
                <button class="btn-save" id="saveBtn" style="display: none;">Save</button>
            @endif
        @endauth
    </div>

    <div class="profile-info">
        <p>Joined {{ $user->created_at->format('Y') }}</p>
        <p>|</p>
        <p>{{ $user->collaborations->count() }} Games Created</p>
    </div>
</div>

<x-card-section 
    title="Created Games"
    :cards="$user->collaborations->map(fn($p) => ['title' => $p->title, 'image' => $p->images->first()?->image_url ?? asset('images/grey.png')])->toArray()"
/>
@endsection

@push('scripts')
<script src="{{ asset('js/profile-edit-button.js') }}"></script>
@endpush