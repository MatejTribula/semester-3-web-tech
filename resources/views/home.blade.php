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
          <x-game-card 
    title="Super Mario" 
    image="#" 
/>

        </div>
      </section>
@endsection
