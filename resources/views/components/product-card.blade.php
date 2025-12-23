@props([
    'id',
    'title',
    'image' => null,
    'tags' => '',
    'favoritesCount' => 0,

])

<a href="{{ route('show', ['id' => $id]) }}" class="card" data-tags="{{ $tags }}" data-favcount="{{ $favoritesCount }}">

    <div class="card-img">
        @if ($image)
        <img src="{{ $image }}" alt="{{ $title }}">
        @endif
    </div>
    <div class="card-info">

        <div class="card-meta">
        <h3 class="card-title">{{ $title }}</h3>
        
        <span class="card-favcount">
            <i class="fa-solid fa-star"></i> {{ $favoritesCount }}
        </span>
        </div>
        @if($tags)
            <div class="tags">
                @foreach(explode(',', $tags) as $tag)
                    <span class="tag"> {{ trim ($tag) }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
