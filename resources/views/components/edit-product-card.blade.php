<div class="card">
    <a  href="{{ route('show', ['id' => $id]) }}" class="card-img">
        @if ($image)
        <img src="{{ $image }}" alt="{{ $title }}">
        @endif
    </a>
    <div class="card-info">
        <h3>{{ $title }}</h3>

             <a  href="{{ route('edit', ['id' => $id]) }}"><i class="fa-solid fa-pen"></i></a>
            
        
    </div>
</div>
