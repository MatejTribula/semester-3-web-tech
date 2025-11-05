@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="profile-header">
    <div class="profile-pfp-name">
        <img class="profile-pfp" src="{{ asset('images/pfp.jpeg') }}" alt="pfp">
       <p class="profile-name">Name</p>
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
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/>


        
@endsection
