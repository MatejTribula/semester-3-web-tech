@php
$carouselImages = collect($products)
    ->map(fn($p) => $p->images[0]->image_url ?? null) // take first image
    ->filter() // remove nulls (products with no images)
    ->values() // reindex
    ->all();
@endphp



@extends('layouts.app')

@section('title', 'Home')

@section('content')

<x-carousel :imageSources="$carouselImages" />


 <x-card-section 
 title="Explore"
 filter-name="homeFilter">
{{-- :filter-options='["A -> Z", "Z -> A"]'> --}}

    @foreach ($products as $product)

        <x-product-card 
            :id="$product->id" 
            :title="$product->title" 
            :image="$product->images[0]->image_url" 
        />
    @endforeach

 </x-card-section>



        
@endsection
