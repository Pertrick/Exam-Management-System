<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/ajax-script.js"></script>
</head>

<body>

    <section class="background">
        <div class="header">
            <div class="name">
                <img src="{{ asset('assets/images/logo.jpeg') }}" alt="{{ config('app.name') }}" style=""
                    width="60" height="40" />
                <h5 style="font-size: 9px; margin-left:4px;">{{ Config('app.name') }}</h5>
            </div>

            <div class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    @guest
                        <li><a class="" href="{{ route('login') }}">Login</a></li>
                        <li><a class="" href="{{ route('register') }}">Register</a></li>
                    @endguest
                    @auth
                        <li><a class="" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="container">
            <div class="main">
                <h1 style="word-spacing:7px; letter-spacing:5px;">{{ config('app.name') }}</h1>
                <p style="font-size: 9px;">Join us today for your preparational exams and tests.</p>

                <div style="display:flex; justify-content:center;">
                    @auth
                        <a class="btn-link" href="{{ route('dashboard') }}">Dashboard</a>
                    @endauth
                    @guest
                        <a class="btn-link" href="{{ route('login') }}">LOGIN</a>
                        <a class="btn-link" href="{{ route('register') }}">REGISTER</a>
                    @endguest

                </div>


            </div>
        </div>

    </section>
    <footer class="footer">
        <p>All Rights Reserved &copy; {{ date('Y') }}</p>
    </footer>

</body>

</html>
