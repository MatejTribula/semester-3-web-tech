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
    <title>@yield('title', 'Default Title')</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
  </head>
  <body>
    <!-- General Container that adds padding/margin where needed -->
    <div class="container">
      <!-- Header Component -->

     @yield('content')

    </div>
    <footer>
      <p>© SDU, Group 9</p>
    </footer>
  </body>

<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/carousel.js') }}"></script>

</html>
