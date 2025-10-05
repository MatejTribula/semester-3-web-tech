<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <title>Home</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
  </head>
  <body>
    <!-- General Container that adds padding/margin where needed -->
    <div class="container">
      <!-- Header Component -->
      <header>
        <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo" />

        <nav>
          <a href="{{ route('home') }}">Home</a>
          <a href="{{ route('library') }}">Library</a>
        </nav>
        <img class="pfp" src="{{ asset('images/pfp.jpeg') }}" alt="profile-pic" />
        <i id="mobileMenuBarTrigger" class="fa-solid fa-bars"></i>

        <div id="accountPopup" class="account-popup">
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>

        <div class="mobile-menu">
          <div class="mm-sites">
            <a href="#">Home</a>
            <a href="{{ route('library') }}">Library</a>
          </div>
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>
      </header>

      <!-- Carousel Component -->
      <div class="carousel">
        <div class="carousel-img">
          <!-- <img src="#" alt="carousel-image"> -->
        </div>
        <div class="carousel-progress">
          <div class="carousel-dot active"></div>
          <div class="carousel-dot"></div>
          <div class="carousel-dot"></div>
        </div>
      </div>

      <section class="card-section">
        <div class="section-header">
          <h2>Explore</h2>

          <!-- Filer-Home Component -->
          <div id="filterHome" class="filter">
            <input
              type="text"
              name="homeFilter"
              id="homeFilter"
              placeholder="Search"
            />
            <p class="filter-divider">|</p>
            <p class="filter-active">A -> Z</p>
            <p>Z -> A</p>
            <p>Lowest Price</p>
            <p>Highest Price</p>
          </div>
        </div>

        <div class="card-container">
          <!-- Card Component -->
          <div class="card">
            <a href="{{ route('product') }}">
                <div class="card-img">
                <!-- <img src="#" alt="card-image"> -->
                </div>
            </a>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>

          <div class="card">
            <div class="card-img">
              <!-- <img src="#" alt="card-image"> -->
            </div>
            <div class="card-info">
              <h3>Card Title</h3>
              <p>00.00 DKK</p>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- Footer Component -->
    <footer>
      <p>© SDU, Group 9</p>
    </footer>
  </body>

<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/carousel.js') }}"></script>

</html>
