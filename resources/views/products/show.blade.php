@extends('layouts.app')

@section('title', 'Product')

@section('content')

<div class="">
<x-carousel/>
<div class="">
  <div>
  <h2>{{ $product->title }}</h2>
    <i class="fa-solid fa-star"></i>
  </div>

  <div class="">
    {{ $product->tags[0]->tag_value }}
  </div>

  <p>{{$product->description}}</p>

  <button type="">Download</button>
</div>
</div>

<section class="product-gallery">
  @foreach ($product->images as $image)
    <img src="{{ $image->image_url }}" alt="">
  @endforeach
</section>



  <!-- Product Page Content -->
  {{-- <section class="card-section">
    <div class="section-header">
      <h2>{{ $product->title }}</h2>
    </div>
    
    <div class="container2">
      <div class="carousel">
        <div class="carousel-img">
          <!--image-->
        </div>
        <div class="carousel-progress">
          <div class="carousel-dot active"></div>
          <div class="carousel-dot"></div>
          <div class="carousel-dot"></div>
        </div>
      </div>

      <!-- Right side - Product information -->
      <div style="flex: 1">
        <h4>Example genre</h4>
        <p>
          {{ $product->description }}
        </p>

        <button style="button">Get</button>
      </div>
    </div>
  </section> --}}

  @endsection