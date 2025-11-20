@php
$carouselImages = collect($products)
    ->map(fn($p) => [
        'src' => $p->images[0]->image_url ?? null,
        'id' => $p->id
    ])
    ->filter(fn($item) => $item['src']) // remove nulls
    ->values()
    ->all();
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')

<x-carousel :imageSources="$carouselImages" />

<x-card-section 
 title="Explore"
 filter-name="homeFilter">
    @foreach ($products as $product)
        <x-product-card 
            :id="$product->id" 
            :title="$product->title" 
            :image="$product->images->first()?->image_url"

        />
    @endforeach
</x-card-section>

@endsection
