<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" 
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    
    
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="header-top">
                <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo">
                <nav>
                    <a href="#">All Games</a>
                    <a href="#">Add</a>
                </nav>
            </div>
            <p><i class="fa-solid fa-right-from-bracket"></i> Logout</p>
        </header>

        <div class="item-list-container">
            <h2>Games</h2>
            <div class="item-list">
                <div class="item">
                    <p>Game Title</p>
                    <div class="item-actions">
                        <p><i class="fa-solid fa-pen"></i></p>
                        <p><i class="fa-solid fa-trash"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>© SDU, Group 9</p>
    </footer>
</body>
</html>
