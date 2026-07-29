<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts: Inter & Cairo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if (app()->getLocale() == 'ar')
            <!-- Bootstrap RTL CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
        @endif

        <style>
            :root {
                --primary-color: #4f46e5;
                --primary-hover: #4338ca;
                --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            }
            body {
                font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
                background: var(--bg-gradient);
                min-height: 100vh;
                color: #f8fafc;
            }
            .card {
                border-radius: 16px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            }
            .lang-switcher {
                position: absolute;
                top: 20px;
                {{ app()->getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }}
                z-index: 1000;
            }
        </style>
    </head>
    <body class="position-relative">
        <!-- Floating Language Switcher -->
        <div class="lang-switcher">
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle shadow-sm" type="button" id="guestLanguageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    🌐 {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                </button>
                <ul class="dropdown-menu {{ app()->getLocale() == 'ar' ? 'dropdown-menu-start' : 'dropdown-menu-end' }} shadow" aria-labelledby="guestLanguageDropdown">
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">{{ __('messages.english') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">{{ __('messages.arabic') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 py-5">
            <div class="mb-4">
                <a href="/">
                    <!-- Logo container -->
                    <div class="bg-white p-3 rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <x-application-logo style="width: 50px; height: 50px; fill: currentColor;" class="text-primary" />
                    </div>
                </a>
            </div>

            <div class="card w-100 text-dark" style="max-width: 450px;">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>

