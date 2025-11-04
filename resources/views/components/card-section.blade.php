{{-- resources/views/components/card-section.blade.php --}}
<section class="card-section">
    <div class="section-header">
        <h2>{{ $title }}</h2>

        {{-- Optional filter slot --}}
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
    
    @forelse($cards ?? [] as $card)
        <x-game-card :title="$card['title']" :image="$card['image']" />
    @empty
        <p>No cards available.</p>
    @endforelse
    </div>
</section>
