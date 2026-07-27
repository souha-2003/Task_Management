<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Task Management System') }}</title>

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
                --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
                --card-hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            body {
                font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
                background: var(--bg-gradient);
                min-height: 100vh;
                color: #334155;
            }

            /* Navbar Styling */
            .navbar {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
            }
            .navbar-brand {
                font-size: 1.25rem;
                letter-spacing: -0.025em;
                background: linear-gradient(to right, #38bdf8, #818cf8);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .nav-link {
                font-weight: 500;
                transition: all 0.25s ease;
                border-bottom: 2px solid transparent;
            }
            .nav-link:hover, .nav-link.active {
                color: #818cf8 !important;
                transform: translateY(-1px);
            }

            /* Cards & Content containers */
            .card {
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 16px !important;
                box-shadow: var(--card-shadow);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(5px);
            }
            .card:hover {
                transform: translateY(-4px);
                box-shadow: var(--card-hover-shadow);
            }

            /* Table Styling */
            .table-responsive {
                border-radius: 12px;
                overflow-x: auto !important; /* تفعيل التمرير الأفقي عند صغر الشاشة */
                -webkit-overflow-scrolling: touch;
                border: 1px solid rgba(226, 232, 240, 0.8);
                width: 100%;
            }
            .table {
                margin-bottom: 0;
                width: 100%;
                border-collapse: collapse;
                min-width: 750px; /* يمنع انضغاط الأعمدة ويجعل الجدول قابلاً للتمرير على الموبايل */
                border: none !important;
                                border-bottom-width: 0 !important;

            }
            /* إلغاء أي خط أسود افتراضي يضيفه بوتستراب أسفل الجدول */
            
            .table thead th {
                background-color: #1e293b !important;
                color: #f8fafc !important;
                font-weight: 600;
                border: none !important;
                padding: 1.1rem 1rem;
            }
            .table tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
            }
            .table tbody tr:last-child {
                border-bottom: none !important; /* إخفاء الخط السفلي لآخر سطر تماماً */
            }
            .table tbody tr:hover {
                background-color: rgba(79, 70, 229, 0.04) !important;
            }
            .table td {
                padding: 1rem;
                background-color: transparent !important;
                border: none !important;
            }

            /* Buttons & Badges */
            .btn {
                border-radius: 8px !important;
                padding: 0.4rem 1.1rem;
                font-weight: 600;
                transition: all 0.2s ease-in-out;
            }
            .btn:hover {
                transform: translateY(-1.5px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            }

            /* أزرار باللون الموفي: الافتراضي أغمق، وفي الهوفر يصبح أفتح */
            .btn-primary {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
                border: none !important;
                color: #ffffff !important;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%) !important;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35) !important;
            }

            /* Buttons matching Logo theme */
            .btn-outline-info {
                color: #38bdf8 !important;
                border-color: #38bdf8 !important;
            }
            .btn-outline-info:hover {
                background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%) !important;
                color: #fff !important;
                border-color: transparent !important;
            }

            .btn-outline-warning {
                color: #f59e0b !important;
                border-color: #f59e0b !important;
            }
            .btn-outline-warning:hover {
                background-color: #f59e0b !important;
                color: #fff !important;
            }

            .badge {
                padding: 0.45em 0.85em !important;
                border-radius: 6px !important;
                font-weight: 600;
            }

            /* Global Alert styling */
            .alert {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }
        </style>
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
                <div class="container">
                    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('tasks.index') }}">
                        <span>🎯</span> {{ __('messages.task_management') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'ms-auto' : 'me-auto' }} mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active fw-bold' : '' }}" href="{{ route('tasks.index') }}">{{ __('messages.tasks') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active fw-bold' : '' }}" href="{{ route('tasks.create') }}">{{ __('messages.create_task') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.index') ? 'active fw-bold' : '' }}" href="{{ route('categories.index') }}">{{ __('messages.categories') }}</a>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center gap-3">
                            <!-- Language Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    🌐 {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="languageDropdown">
                                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">{{ __('messages.english') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">{{ __('messages.arabic') }}</a></li>
                                </ul>
                            </div>

                            <!-- User Settings Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    👤 {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            ⚙️ {{ __('messages.profile') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                🚪 {{ __('messages.logout') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow-1 py-4">
                <div class="container">
                    <!-- Global Flash Messages -->
                    @if (session('success'))
                        <x-flash type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-flash type="danger" :message="session('error')" />
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 mt-auto">
                <div class="container text-center text-secondary small">
                   {{__('messages.system_footer')}} 
                </div>
            </footer>
        </div>
    </body>
</html>
