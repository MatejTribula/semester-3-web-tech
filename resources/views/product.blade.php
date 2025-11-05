@extends('layouts.app')

@section('title', 'Product')

@section('content')

  <!-- Product Page Content -->
  <section class="card-section">
    <div class="section-header">
      <h2>GameTitle</h2>
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
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec 
          dapibus faucibus feugiat. Sed augue ex, cursus ut feugiat augue, 
          condimentum ut nulla. Cras rutrum turpis et mauris scelerisque, 
          a accumsan lorem rhoncus.
        </p>
        <p class="price">21 DKK</p>
        <button style="button">Purchase</button>
      </div>
    </div>
  </section>

  @endsection