<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }
            .card {
                border-radius: 15px;
            }
        </style>
    </head>
    <body class="text-dark">
        <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 py-5">
            <div class="mb-4">
                <a href="/">
                    <!-- Logo container -->
                    <div class="bg-white p-3 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <x-application-logo style="width: 50px; height: 50px; fill: currentColor;" class="text-primary" />
                    </div>
                </a>
            </div>

            <div class="card shadow-sm border-0 w-100" style="max-width: 450px;">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
