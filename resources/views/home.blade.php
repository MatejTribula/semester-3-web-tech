@extends('layouts.app')

@section('title', 'Home')

@section('content')
      <!-- Carousel Component -->
      <x-carousel/>

      <section class="card-section">
        <div class="section-header">
          <h2>Explore</h2>

          <!-- Fitler-Home Component -->
          <div id="filterHome" class="filter">
            <input
              type="text"
              name="homeFilter"
              id="homeFilter"
              placeholder="Search"
            />
            <p class="filter-divider">|</p>
            <p class="filter-active">A -> Z</p>
            <p>Z -> A</p>
            <p>Lowest Price</p>
            <p>Highest Price</p>
          </div>
        </div>

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
