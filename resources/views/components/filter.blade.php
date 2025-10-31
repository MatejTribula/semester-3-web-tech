<div id="filter{{ $name }}" class="filter">
            <input
              type="text"
              name="{{ $name }}"
              id="{{ $name }}"
              placeholder="Search"
            />
            <p class="filter-divider">|</p>
            @if(count($options))
        <p class="filter-divider">|</p>
        @foreach($options as $option)
            <p class="{{ $loop->first ? 'filter-active' : '' }}">{{ $option }}</p>
        @endforeach
    @endif
          </div>
        </div>