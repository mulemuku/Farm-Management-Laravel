<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Management System</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: url("{{ asset('images/home.jpg') }}") no-repeat center center/cover;
            color: white;
        }

        header {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            text-align: center;
        }

        header img {
            height: 50px;
            margin-bottom: 10px;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            margin: 20px;
        }

        main h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 5px black;
        }

        main p {
            font-size: 1.2rem;
            max-width: 600px;
            text-shadow: 1px 1px 3px black;
        }

        .buttons a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            font-size: 1.1rem;
            color: white;
            background-color: #86AA42;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.2s, background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .buttons a:hover {
            background-color: #5c7d2f;
            transform: translateY(-5px);
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }

        footer a {
            color: #86AA42;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('logo.png') }}" alt="Farmer Management System Logo">
        <h1>Welcome to the Farmer Management System</h1>
    </header>

    <main>
        <h1>Effortless Farmer and Loan Management</h1>
        <p>
            Our system empowers administrators to manage farmers, loans, and farming activities seamlessly.
            Designed with modular architecture, scalability, and security in mind.
        </p>

        <div class="buttons">
            @auth
                <a href="{{ url('/dashboard') }}">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log In</a>
            @endauth
        </div>
    </main>

    <footer>
        <small>
            Developed for GNA by Mukuka Mulenga | <a href="mailto:twomulenga@gmail.com">twomulenga@gmail.com</a>
        </small>
    </footer>
</body>
</html>
