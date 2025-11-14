@php
$carouselImages = $product->images
    ->pluck('image_url')
    ->filter()
    ->values()
    ->all();


$isFavorited = auth()->check()
        ? $product->favorites->contains('id', auth()->id())
        : false;
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

    @auth
        <button id="favorite-btn"
                aria-pressed="{{ $isFavorited ? 'true' : 'false' }}"
                data-favorited="{{ $isFavorited ? 1 : 0 }}"
                data-star-url="{{ route('star', $product->id) }}"
                data-unstar-url="{{ route('unstar', $product->id) }}"
                style="background:none;border:0;cursor:pointer;font-size:1.5rem;color:var(--clr-primary);">
            <i class="{{ $isFavorited ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
        </button>
      @else
        <a href="{{ route('login') }}" title="Login to favorite">
          <i class="fa-regular fa-star" style="font-size:1.5rem;color:var(--clr-grey)"></i>
        </a>
    @endauth

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

  @endsection