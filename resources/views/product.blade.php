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
          <a href="#">Home</a>
          <a href="#">Library</a>
        </nav>
        <img class="pfp" src="{{ asset('images/pfp.jpeg') }}" alt="profile-pic" />
        <i id="mobileMenuBarTrigger" class="fa-solid fa-bars"></i>

        <div id="accountPopup" class="account-popup">
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>

        <div class="mobile-menu">
          <div class="mm-sites">
            <a href="#">Home</a>
            <a href="#">Library</a>
          </div>
          <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </div>
      </header>


      <!-- Product Page Content -->
      <section class="card-section">
        <div class="section-header">
          <h2>GameTitle</h2>
        </div>
        
        <div class="container2">
          <div class="carousel">
            <div class="carousel-img">
              <!--image-->
            </div>
            <div class="carousel-progress">
              <div class="carousel-dot active"></div>
              <div class="carousel-dot"></div>
              <div class="carousel-dot"></div>
            </div>
          </div>

          <!-- Right side - Product information -->
          <div style="flex: 1">
            <h4>Example genre</h4>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec 
              dapibus faucibus feugiat. Sed augue ex, cursus ut feugiat augue, 
              condimentum ut nulla. Cras rutrum turpis et mauris scelerisque, 
              a accumsan lorem rhoncus.
            </p>
            <p class="price">21 DKK</p>
            <button style="button">Purchase</button>
          </div>
        </div>
      </section>
    <!-- Footer Component -->
    <footer>
      <p>© SDU, Group 9</p>
    </footer>
  </body>

<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/carousel.js') }}"></script>

</html>
