<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Farmer Management System') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            background: url('/images/home.jpg') no-repeat center center/cover;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .logo {
            margin-top: 20px;
        }

        .logo img {
            height: 80px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="main-content">
        <!-- Logo -->
        <div class="logo">
            <a href="/">
                <img src="{{ asset('logo.png') }}" alt="Farmer Management System Logo">
            </a>
        </div>

        <!-- Main Content -->
        <div class="form-container">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <footer>
        Developed for GNA by Mukuka Mulenga | <a href="mailto:twomulenga@gmail.com">twomulenga@gmail.com</a>
    </footer>
</body>
</html>
