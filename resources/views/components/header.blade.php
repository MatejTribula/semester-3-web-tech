 <header>
        <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo" />

        <nav>
          <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-active' : '' }}">Home</a>
          {{-- <a href="{{ route('favorites') }}" class="{{ request()->routeIs('favorites') ? 'text-active' : '' }}">Favorites</a>
          <a href="{{ route('my.games') }} " class="{{ request()->routeIs('my.games') ? 'text-active' : '' }}">My Games</a> --}}
        </nav>
        <img class="pfp" src="{{ asset('images/pfp.jpeg') }}" alt="profile-pic" />
        <i id="mobileMenuBarTrigger" class="fa-solid fa-bars"></i>

        <div id="accountPopup" class="account-popup">
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>

        <div class="mobile-menu">
          <div class="mm-sites">
            <a href="#">Explore</a>
            <a href="{{ route('library') }}">Library</a>
          </div>
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>
      </header>