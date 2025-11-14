@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="profile-header">
    <div class="profile-pfp-name">
        <img class="profile-pfp" src="{{ $user->avatar_url ?? asset('images/grey.png') }}" alt="{{ $user->nickname }}">
        <p class="profile-name">{{ $user->nickname }}</p>
    </div>

    <div class="profile-info">
        <p>Joined 2025</p>
        <p>|</p>
        <p>108 Games Created</p>
    </div>
</div>

 <x-card-section 
    title="Created Games"
    :cards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/>


        
@endsection
