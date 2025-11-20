@php
$carouselImages = collect($products)
    ->map(fn($p) => $p->images[0]->image_url ?? null)
    ->filter()
    ->values()
    ->all();
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <x-carousel :imageSources="$carouselImages" />

    <x-card-section 
        title="Explore"
        filter-name="homeFilter">

        <div class="tag-filter" id="tagFilter">
            @foreach ($tags as $tag)
                <button 
                    type="button" 
                    class="tag-button" 
                    data-tag="{{ strtolower($tag->tag_value) }}"
                >
                    {{ $tag->tag_value }}
                </button>
            @endforeach
        </div>

        @foreach ($products as $product)
            <x-product-card 
                :id="$product->id" 
                :title="$product->title" 
                :image="$product->images[0]->image_url" 
                :tags="$product->tags->pluck('tag_value')->map(fn($t) => strtolower($t))->implode(',')"
            />
        @endforeach

    </x-card-section>
@endsection 

@push('scripts')
    <script src="{{ asset('js/tag-filter.js') }}"></script>
@endpush