<a href="{{ route('show', ['id' => $id]) }}" class="card">
    <div class="card-img">
        @if ($image)
        <img src="{{ $image }}" alt="{{ $title }}">
        @endif
    </div>
    <div class="card-info">
        <h3>{{ $title }}</h3>
    </div>
</a>
