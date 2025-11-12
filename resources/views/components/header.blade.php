 <header>
        <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo" />

        <nav>
          <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-active' : '' }}">Home</a>
          <a href="{{ route('favorites') }}" class="{{ request()->routeIs('favorites') ? 'text-active' : '' }}">Favorites</a>
          <a href="{{ route('my-uploads') }} " class="{{ request()->routeIs('my-uploads') ? 'text-active' : '' }}">My Uploads</a> 
        </nav>
        <img class="pfp" src="{{ asset('images/pfp.jpeg') }}" alt="profile-pic" />
        <i id="mobileMenuBarTrigger" class="fa-solid fa-bars"></i>

        <div id="accountPopup" class="account-popup">
          <a href = "{{ route('profile') }}" ><p><i class="fa fa-address-card"></i> Profile </p></a>
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>

        <div class="mobile-menu">
          <div class="mm-sites">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('favorites') }}">Favorites</a>
            <a href="{{ route('my-uploads') }}">My Uploads</a>
          </div>
          <p><a href = "{{ route('profile') }}" ><i class="fa fa-address-card"></i> Profile </a></p>
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>

          <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-link">Logout</button>
      </form>
        </div>
      </header>