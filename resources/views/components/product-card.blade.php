<a href="{{ route('show', ['id' => $id]) }}" class="card">
    <div class="card-img">
        <img width = "100%" src="{{ $image }}" alt="{{ $title }}">
    </div>
    <div class="card-info">
        <h3>{{ $title }}</h3>
    </div>
</a>
