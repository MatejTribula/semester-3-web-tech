<section class="card-section">
    <div class="section-header">
        <h2>{{ $title }}</h2>

        @if(isset($filterOptions) && count($filterOptions))
            <x-filter :name="$filterName" :options="$filterOptions" />
        @endif
    </div>

    <div class="card-container">
        @forelse($cards as $card)
            <x-game-card :title="$card['title']" :image="$card['image']" />
        @empty
            <p>No cards available.</p>
        @endforelse
    </div>

    
</section>
