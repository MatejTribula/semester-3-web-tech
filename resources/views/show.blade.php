@extends('layouts.app')

@section('title', 'Product')

@section('content')

  <!-- Product Page Content -->
  <section class="card-section">
    <div class="section-header">
      <h2>{{ $product->title }}</h2>
      <div style="margin-left: auto;">
        <a href="https://google.com">Star</a>
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
        <h4>Adventure</h4>
        <p>
          {{ $product->description }}
        </p>

        <button style="button">Get</button>
      </div>
    </div>
  </section>

  @endsection