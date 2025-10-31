@extends('layouts.app')

@section('title', 'Home')

@section('content')
      <!-- Carousel Component -->
      <x-carousel/>

      <section class="card-section">
        <div class="section-header">
          <h2>Explore</h2>

          <!-- Fitler-Home Component -->
          <x-filter name="homeFilter" :options="['A -> Z', 'Z -> A', 'Lowest Price', 'Highest Price']" />

        <div class="card-container">
          <!-- Card Component -->
          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>
        </div>
      </section>
@endsection
