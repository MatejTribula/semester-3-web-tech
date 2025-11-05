<section class="card-section">
    <div class="section-header">
        <h2>{{ $title }}</h2>

        @isset($filterSlot)
            {{ $filterSlot }}
        @elseif(isset($filterOptions) && count($filterOptions))
            <x-filter :name="$filterName" :options="$filterOptions" />
        @endif
    </div>

    <div class="card-container">
    @if(!$slot->isEmpty())
        {{ $slot }}
    @endif
    
    @foreach($cards ?? [] as $card)
    <x-game-card :title="$card['title']" :image="$card['image']" />
@endforeach

@foreach($myCards ?? [] as $card)
    <x-my-game-card :title="$card['title']" :image="$card['image']" />
@endforeach
    </div>
</section>
