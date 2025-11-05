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

    <link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
  </head>
  <body class="page--login">
     <!-- login and register-page container -->
     <main class="login-center">
        <section class="login-card">

            <h1>Register</h1>
            <!-- login and register form with fields -->
            <form id="login-form">
                <div class ="field">
                <label for="email"> <b>Email</b> </label>
                <input id="email" name="email" type="email" placeholder="Enter E-mail" name="E-mail" required>
                </div>
            
                <div class ="field">
                <label for="password"> <b>Password</b></label>
                <input id="text" name="password" type="password" placeholder="Enter Password" name="Password" required>
                </div>

                <button type="continue" class="continue-btn">Continue</button>
            </form>
            <!-- Navigation text to login-page -->
            <p class="register-text">Already have an account? <a href="{{ route('login') }}" class="small-register">Log in here</a></p>
        </section>
    </main>

</div>
<footer>
<p>© SDU, Group 9</p>
</footer>
</body>


</html>