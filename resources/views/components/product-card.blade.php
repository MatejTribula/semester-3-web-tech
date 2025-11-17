@props([
    'id',
    'title',
    'image' => null,
    'tags' => '',
    
])

<a href="{{ route('show', ['id' => $id]) }}" class="card" data-tags="{{ $tags }}">

    <div class="card-img">
        @if ($image)
        <img src="{{ $image }}" alt="{{ $title }}">
        @endif
    </div>
    <div class="card-info">
        <h3>{{ $title }}</h3>

        @if($tags)
            <div class="tags">
                @foreach(explode(',', $tags) as $tag)
                    <span class="tag"> {{ trim ($tag) }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
