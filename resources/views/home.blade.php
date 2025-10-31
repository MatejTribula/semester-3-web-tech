@extends('layouts.app')

@section('title', 'Home')

@section('content')
      <!-- Carousel Component -->
      <x-carousel/>

 <x-card-section 
    title="Explore"
    filter-name="homeFilter"
    :filter-options='["A -> Z", "Z -> A", "Lowest Price", "Highest Price"]'
    :cards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/>


        
@endsection
