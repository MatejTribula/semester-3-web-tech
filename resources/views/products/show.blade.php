@php
$carouselImages = $product->images
    ->pluck('image_url')
    ->filter()
    ->values()
    ->all();
@endphp


@extends('layouts.app')

@section('title', 'Product')

@section('content')

<div class="product-info-image-container">

<x-carousel :imageSources="$carouselImages" />

<div class="product-info-container">
<div class="product-info">
  <div class="product-info-header">
  <h2>{{ $product->title }}</h2>
    <i class="fa-solid fa-star"></i>
  </div>

  <div class="product-tags">
    <p>{{ $product->tags[0]->tag_value }}</p>
  </div>

  <p>{{$product->description}}</p>
</div>


  <a class="download-btn" href="{{ $product->file_url }}" download>Download File</a>
  </div>
</div>


<section class="product-gallery">
  <h2>Gallery</h2>
  <div class="product-gallery-grid">
  @foreach ($product->images as $image)
    <img src="{{ $image->image_url }}" alt="">
  @endforeach
  </div>
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