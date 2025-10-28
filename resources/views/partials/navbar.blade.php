<header>
  <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo" />

  <nav>
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('favorites') }}">Favorites</a>
  </nav>
  <img class="pfp" src="{{ asset('images/pfp.jpeg') }}" alt="profile-pic" />
  <i id="mobileMenuBarTrigger" class="fa-solid fa-bars"></i>

  <div id="accountPopup" class="account-popup">
    <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
  </div>

  <div class="mobile-menu">
    <div class="mm-sites">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('favorites') }}">Favorites</a>
    </div>
    <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
  </div>
</header>