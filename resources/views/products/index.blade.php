@php
$carouselImages = collect($products)
    ->map(fn($p) => [
        'src' => $p->images[0]->image_url ?? null,
        'id' => $p->id
    ])
    ->filter(fn($item) => $item['src']) // remove nulls
    ->values()
    ->all();
@endphp

@extends('layouts.app')

@section('title', 'Home')

@section('content')

<x-carousel :imageSources="$carouselImages" />

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

        </button>
        </div>
        
        <x-card-section

        title="Explore"
        filter-name="homeFilter">

        <x-slot:filterSlot>
        <button id="sortMostFavorited" type="button" class="btn btn-primary">
            Sort by Most Favorited
        </button>
    </x-slot:filterSlot>

    @foreach ($products as $product)
        <x-product-card
            :id="$product->id"
            :title="$product->title"
            :image="$product->images[0]->image_url"
            :tags="$product->tags->pluck('tag_value')->map(fn($t) => strtolower($t))->implode(',')"
            :favoritesCount="$product->favorites_count"
                />
            @endforeach

    </x-card-section>
@endsection 

@push('scripts')
    <script src="{{ asset('js/tag-filter.js') }}"></script>
    <script src="{{ asset('js/favorites-sort.js') }}"></script>
@endpush