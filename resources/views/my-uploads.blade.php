@extends('layouts.app')

@section('title', 'My Uploads')

@section('content')


<x-card-section 
    title="Explore"
    filter-name="homeFilter"
    :filter-options='["A -> Z", "Z -> A"]'
    :myCards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'>
    <x-add-game-card/>
</x-card-section>


        
@endsection
