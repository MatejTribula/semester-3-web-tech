@extends('layouts.app')

@section('title', 'Favorites')

@section('content')


 <x-card-section 
    title="Favorites"
    filter-name="homeFilter"
    :filter-options='["A -> Z", "Z -> A"]'
    :cards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/>


        
@endsection
