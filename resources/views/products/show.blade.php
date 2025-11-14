@extends('layouts.app')

@section('title', 'Product')

@section('content')

@php
    $isFavorited = auth()->check()
        ? $product->favorites->contains('id', auth()->id())
        : false;
@endphp

  <!-- Product Page Content -->
  <section class="card-section">
    <div class="section-header--space">
      <div class="section-header-left">
          <h2>{{ $product->title }}</h2>
      </div>

      <div class="section-header-right">
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
  </section>


  @endsection