<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Task Management System') }}</title>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f4f6f9;
            }
            .navbar {
                border-bottom: 3px solid #0d6efd;
            }
            .alert {
                border-radius: 10px;
            }
        </style>
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
                <div class="container">
                    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('tasks.index') }}">
                        <span>🎯</span> Task Manager
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active fw-bold' : '' }}" href="{{ route('tasks.index') }}">Tasks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active fw-bold' : '' }}" href="{{ route('tasks.create') }}">Add Task</a>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-white-50">
                                Welcome, <strong>{{ Auth::user()->name }}</strong>
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm px-3">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow-1 py-4">
                <div class="container">
                    <!-- Global Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 mt-auto">
                <div class="container text-center text-secondary small">
                    &copy; {{ date('Y') }} Task Management System. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
