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
    </div>


    <x-card-section 
        title="Explore"
        filter-name="homeFilter">


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