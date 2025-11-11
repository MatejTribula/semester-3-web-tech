@extends('layouts.app')

@section('title', 'Home')

@section('content')
      <x-carousel/>


 <x-card-section 
 title="Explore"
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



        
@endsection
