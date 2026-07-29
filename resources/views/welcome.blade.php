<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('messages.task_management') }}</title>

        <!-- Google Fonts: Inter & Cairo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Pre-compiled Bootstrap CSS via CDN -->
        @if (app()->getLocale() == 'ar')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
        @else
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                color: #f8fafc;
                min-height: 100vh;
                display: flex;
                flex-column;
            }
            .hero-section {
                padding: 100px 0;
            }
            .feature-card {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                padding: 30px;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(255, 255, 255, 0.2);
            }
            .navbar {
                background: transparent !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
            }
            .btn-primary {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
                border: none !important;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%) !important;
                box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            }
            .brand-gradient {
                background: linear-gradient(to right, #38bdf8, #818cf8);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            p, .text-secondary-emphasis, .text-muted {
                color: #cbd5e1 !important;
            }
            .feature-card h4 {
                color: #ffffff !important;
            }
            @media (max-width: 767.98px) {
                .display-3 {
                    font-size: 2.25rem !important;
                }
                .lead {
                    font-size: 1rem !important;
                    margin-bottom: 2rem !important;
                }
                .hero-section {
                    padding: 50px 0 !important;
                }
                .btn-lg {
                    font-size: 1rem !important;
                    padding: 0.75rem 1.5rem !important;
                }
            }
        </style>
    </head>
    <body class="d-flex flex-column justify-content-between">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark py-3">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
                    <span>🎯</span> <span class="brand-gradient">{{ __('messages.task_management') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#welcomeNavbar" aria-controls="welcomeNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="welcomeNavbar">
                    <ul class="navbar-nav {{ app()->getLocale() == 'ar' ? 'ms-auto' : 'me-auto' }}"></ul>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Language Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                🌐 {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                            </button>
                            <ul class="dropdown-menu {{ app()->getLocale() == 'ar' ? 'dropdown-menu-start' : 'dropdown-menu-end' }} shadow" aria-labelledby="langDropdown">
                                <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">{{ __('messages.english') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">{{ __('messages.arabic') }}</a></li>
                            </ul>
                        </div>

                        <!-- Auth Links -->
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm px-4 fw-semibold">{{ __('messages.dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">{{ __('messages.login') }}</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3 fw-semibold">{{ __('messages.register') }}</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Hero Section -->
        <main class="hero-section flex-grow-1 d-flex align-items-center">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">
                        <span class="badge mb-3 px-3 py-2" style="background: rgba(99, 102, 241, 0.1); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.2); border-radius: 30px; font-weight: 600; font-size: 0.8rem; letter-spacing: 0.05em; text-transform: uppercase;">
                            ✨ {{ app()->getLocale() == 'ar' ? 'منصتك الذكية لإدارة المهام' : 'Your Smart Task Manager' }}
                        </span>
                        <h1 class="display-3 fw-extrabold mb-4">
                            {{ app()->getLocale() == 'ar' ? 'نظم مهامك اليومية بكفاءة عالية' : 'Organize Your Tasks with High Efficiency' }}
                        </h1>
                        <p class="lead text-secondary-emphasis mb-5">
                            {{ app()->getLocale() == 'ar' ? 'أداة سهلة ومميزة لمساعدتك على إدارة أعمالك، وتصنيف المهام، ومتابعة تواريخ الاستحقاق بكل سهولة وأمان.' : 'A simple and powerful tool to help you manage work, categorize tasks, and track due dates with ultimate security.' }}
                        </p>
                        
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            @auth
                                <a href="{{ route('tasks.index') }}" class="btn btn-primary px-4 py-2.5 fw-semibold" style="border-radius: 10px; font-size: 0.95rem; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);">{{ __('messages.tasks') }}</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2.5 fw-semibold" style="border-radius: 10px; font-size: 1rem; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);">{{ __('messages.create_first_task') }}</a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light px-4 py-2.5 fw-semibold" style="border-radius: 10px; font-size: 1rem;">{{ __('messages.login') }}</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Features Cards Grid -->
                <div class="row mt-5 pt-5 g-4 text-start">
                    <div class="col-md-4 col-12">
                        <div class="feature-card h-100">
                            <div class="fs-1 mb-3">📅</div>
                            <h4 class="fw-bold mb-2">{{ app()->getLocale() == 'ar' ? 'إدارة المهام بسهولة' : 'Easy Task Management' }}</h4>
                            <p class="text-secondary-emphasis">{{ app()->getLocale() == 'ar' ? 'أنشئ المهام، حدد الأولويات، وتواريخ الاستحقاق بسهولة فائقة.' : 'Create tasks, set priorities, and manage due dates with complete simplicity.' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="feature-card h-100">
                            <div class="fs-1 mb-3">🎨</div>
                            <h4 class="fw-bold mb-2">{{ app()->getLocale() == 'ar' ? 'تصنيفات ملونة مخصصة' : 'Colored Custom Categories' }}</h4>
                            <p class="text-secondary-emphasis">{{ app()->getLocale() == 'ar' ? 'نظم مهامك تحت تصنيفات مخصصة مع رموز لونية لسهولة التمييز البصري.' : 'Organize tasks under custom categories with color codes for easier visual distinction.' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="feature-card h-100">
                            <div class="fs-1 mb-3">🔒</div>
                            <h4 class="fw-bold mb-2">{{ app()->getLocale() == 'ar' ? 'حماية وخصوصية تامة' : 'Absolute Privacy & Security' }}</h4>
                            <p class="text-secondary-emphasis">{{ app()->getLocale() == 'ar' ? 'بياناتك وملاحظاتك الشخصية مشفرة بالكامل وآمنة بموجب أحدث معايير الحماية.' : 'Your data and personal notes are fully encrypted and secured under the latest standards.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 border-top border-secondary border-opacity-10 text-center text-secondary small">
            <div class="container">
                {{ __('messages.system_footer') }}
            </div>
        </footer>

        <!-- Bootstrap JS Bundle from CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
