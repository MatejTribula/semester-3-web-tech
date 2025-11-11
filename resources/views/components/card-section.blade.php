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
        {{ $slot }}
    </div>
</section>
