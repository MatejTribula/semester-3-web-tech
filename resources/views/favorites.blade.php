@extends('layouts.app')

@section('title', 'Favorites')

@section('content')


 <x-card-section 
 title="Favorites"
 filter-name="homeFilter"
:filter-options='["A -> Z", "Z -> A"]'>
    @foreach ($products as $product)

        <x-product-card 
            :id="$product->id" 
            :title="$product->title" 
            :image="$product->images[0]->image_url" 
        />
    @endforeach

 </x-card-section>
    @if($products->isEmpty())
        <p class="text-center">You have no favorite products yet. Star the games you like to see them here :)</p>
    @endif

        
@endsection
