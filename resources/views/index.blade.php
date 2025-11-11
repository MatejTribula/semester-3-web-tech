@extends('layouts.app')

@section('title', 'Home')

@section('content')
      <!-- Carousel Component -->
      <x-carousel/>

 {{-- <x-card-section 
    title="Explore"
    filter-name="homeFilter"
    :filter-options='["A -> Z", "Z -> A"]'
    :cards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/> --}}

 <x-card-section 
    title="Explore"
    filter-name="homeFilter"
    :filter-options='["A -> Z", "Z -> A"]'
    :cards='[
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"],
        ["title" => "Puppets Adventure 2", "image" => "#"]
    ]'
/>

{{-- {{ $products[0]->title }} --}}
{{-- <img src="{{ $products[1]->images[0]->image_url }}" alt=""> --}}

@foreach ($products as $product)
    <img src="{{ $product->images[0]->image_url }}" alt="">
    <p>{{$product->id}}</p>
    <p>{{$product->title}}</p>

@endforeach
        
@endsection
