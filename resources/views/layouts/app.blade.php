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
            /* Custom Tooltips styling */
            .tooltip-inner {
                background-color: #0f172a !important;
                color: #f8fafc !important;
                font-family: inherit;
                font-size: 0.85rem !important;
                padding: 8px 14px !important;
                border-radius: 8px !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
            .bs-tooltip-top .tooltip-arrow::before, 
            .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before {
                border-top-color: #0f172a !important;
            }
            .bs-tooltip-bottom .tooltip-arrow::before, 
            .bs-tooltip-auto[data-popper-placement^=bottom] .tooltip-arrow::before {
                border-bottom-color: #0f172a !important;
            }
            .bs-tooltip-start .tooltip-arrow::before, 
            .bs-tooltip-auto[data-popper-placement^=left] .tooltip-arrow::before {
                border-left-color: #0f172a !important;
            }
            .bs-tooltip-end .tooltip-arrow::before, 
            .bs-tooltip-auto[data-popper-placement^=right] .tooltip-arrow::before {
                border-right-color: #0f172a !important;
            }

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
                z-index: 1050 !important; /* لضمان ظهور الناف بار وقوائمه فوق كل محتوى الصفحة */
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
                border: none !important;
                border-bottom-width: 0 !important;
            }
            @media (min-width: 992px) {
                .table {
                    min-width: 750px; /* يمنع انضغاط الأعمدة على الشاشات الكبيرة */
                }
            }
            @media (max-width: 991.98px) {
                .table td, .table th {
                    padding: 0.5rem 0.3rem !important;
                    font-size: 0.75rem;
                }
                .table .btn {
                    padding: 0.2rem 0.4rem !important;
                    font-size: 0.7rem !important;
                }
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
                padding: 0.55em 0.95em !important;
                border-radius: 6px !important;
                font-weight: 600;
            }

            /* Modern SaaS Status Badge Styles */
            .badge-status-pending, .btn-status-pending {
                background-color: #f1f5f9 !important;
                color: #475569 !important;
                border: none !important;
            }
            .badge-status-pending:hover, .btn-status-pending:hover {
                background-color: #e2e8f0 !important;
                color: #475569 !important;
            }
            
            .badge-status-in_progress, .btn-status-in_progress {
                background-color: #dbeafe !important;
                color: #1e40af !important;
                border: none !important;
            }
            .badge-status-in_progress:hover, .btn-status-in_progress:hover {
                background-color: #bfdbfe !important;
                color: #1e40af !important;
            }
            
            .badge-status-review, .btn-status-review {
                background-color: #fef3c7 !important;
                color: #92400e !important;
                border: none !important;
            }
            .badge-status-review:hover, .btn-status-review:hover {
                background-color: #fde68a !important;
                color: #92400e !important;
            }
            
            .badge-status-completed, .btn-status-completed {
                background-color: #d1fae5 !important;
                color: #065f46 !important;
                border: none !important;
            }
            .badge-status-completed:hover, .btn-status-completed:hover {
                background-color: #a7f3d0 !important;
                color: #065f46 !important;
            }

            /* Global Alert styling */
            .alert {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            /* Custom Pagination Styles */
            .pagination .page-item .page-link {
                color: #4f46e5 !important;
                border-radius: 6px;
                margin: 0 2px;
                border: 1px solid #e2e8f0;
                transition: all 0.2s ease;
            }
            .pagination .page-item.active .page-link {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
                border-color: transparent !important;
                color: #ffffff !important;
                box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25) !important;
            }
            .pagination .page-item .page-link:hover {
                background-color: rgba(99, 102, 241, 0.08) !important;
                border-color: #6366f1 !important;
                color: #4f46e5 !important;
            }
            .pagination .page-item.disabled .page-link {
                color: #94a3b8 !important;
                background-color: #f8fafc !important;
                border-color: #e2e8f0 !important;
            }

            /* حل مشكلة تداخل وظهور قائمة الإشعارات خلف المحتوى وتحت الجدول */
            #notificationCenterDropdown .dropdown-menu {
                z-index: 1080 !important;
            }
            
            /* تحسين استجابة القائمة على الشاشات الصغيرة لتجنب خروجها عن الشاشة وتداخلها */
            @media (max-width: 991.98px) {
                #notificationCenterDropdown .dropdown-menu {
                    display: none !important; /* إلغاء ومنع القائمة المنسدلة تماماً على الموبايل والاعتماد على الانتقال الفوري */
                }
                /* لضمان عدم قص القائمة داخل القائمة المنسدلة للناف بار */
                .navbar-collapse {
                    overflow: visible !important;
                }
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
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active fw-bold' : '' }}" href="{{ route('tasks.index') }}">{{ __('messages.tasks') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active fw-bold' : '' }}" href="{{ route('tasks.create') }}">{{ __('messages.create_task') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.index') ? 'active fw-bold' : '' }}" href="{{ route('categories.index') }}">{{ __('messages.categories') }}</a>
                            </li>
                            @if (Auth::user()->can('manage users') || Auth::user()->can('manage roles'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.users.*') || request()->routeIs('roles.*') ? 'active fw-bold' : '' }}" href="#" id="adminNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ⚙️ {{ __('messages.administration') }}
                                </a>
                                <ul class="dropdown-menu shadow" aria-labelledby="adminNavbarDropdown" style="min-width: 200px; padding: 0.3rem;">
                                    @can('manage users')        
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.users.index') }}" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding: 0.6rem 1.25rem;">
                                                👥 {{ __('messages.users_management') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('manage roles')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('roles.index') }}" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding: 0.6rem 1.25rem;">
                                                🔑 {{ __('messages.roles_management') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            @endif
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

                             <!-- Notifications Bell Dropdown -->
                            <div class="dropdown me-1" id="notificationCenterDropdown">
                                <button class="btn btn-outline-light btn-sm position-relative" type="button" id="bellDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 50%; width: 34px; height: 34px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                    🔔
                                    <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.65rem;">
                                        0
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow py-0" aria-labelledby="bellDropdown" style="width: 360px; max-height: 400px; overflow-y: auto; border-radius: 12px;">
                                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between gap-2 bg-light" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">🔔 {{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}</h6>
                                        <button onclick="markAllNotificationsAsRead(event)" class="btn btn-link btn-sm p-0 text-primary text-decoration-none fw-semibold" style="font-size: 0.75rem;">
                                            {{ app()->getLocale() == 'ar' ? 'تحديد الكل كمقروء' : 'Mark all read' }}
                                        </button>
                                    </div>
                                    <div id="notificationList" class="list-group list-group-flush">
                                        <div class="p-4 text-center text-secondary small">
                                            {{ app()->getLocale() == 'ar' ? 'جاري التحميل...' : 'Loading...' }}
                                        </div>
                                    </div>
                                    <div class="p-2 border-top text-center bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                                        <a href="{{ route('notifications.history') }}" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.8rem;">
                                            {{ app()->getLocale() == 'ar' ? 'عرض كل الإشعارات 🔗' : 'View All Notifications 🔗' }}
                                        </a>
                                    </div>
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

        <!-- Firebase SDKs Compatibility -->
        <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js"></script>

        <script>
            // إعدادات Firebase الخاصة بمشروعك
            const firebaseConfig = {
                apiKey: "AIzaSyDmKeP3bqBfDYet_usW46t89IxoQds-DdA",
                authDomain: "task-management-c3bff.firebaseapp.com",
                projectId: "task-management-c3bff",
                storageBucket: "task-management-c3bff.firebasestorage.app",
                messagingSenderId: "731879977881",
                appId: "1:731879977881:web:53e7b1f5aae69734539908",
                measurementId: "G-HXDX8LDZ61"
            };

            // تهيئة الفايربيز
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            // طلب إذن الإشعارات والحصول على الـ Token
            Notification.requestPermission()
                .then((permission) => {
                    if (permission === 'granted') {
                        if ('serviceWorker' in navigator) {
                            return navigator.serviceWorker.register('/firebase-messaging-sw.js')
                                .then((registration) => {
                                    console.log('تم تسجيل Service Worker بنجاح:', registration);
                                    return messaging.getToken({
                                        serviceWorkerRegistration: registration,
                                        vapidKey: 'BEUKgQcCrD-_M5dKuR0v5QzE5Up5vitLgcATCX9mVnHZU4lfdY9GP8oBrJ8MrqUy0Q0WD7v87F30wdyfcYCi9FE'
                                    });
                                });
                        } else {
                            throw new Error('المتصفح لا يدعم Service Worker.');
                        }
                    } else {
                        throw new Error('لم يتم قبول صلاحية الإشعارات.');
                    }
                })
                .then((token) => {
                    console.log('Firebase Device Token:', token);
                    
                    // إرسال الرمز للباك إند لحفظه
                    axios.post('/update-device-token', {
                        device_token: token
                    })
                    .then(response => {
                        console.log('تم حفظ رمز الجهاز بنجاح في قاعدة البيانات.');
                    })
                    .catch(error => {
                        console.error('حدث خطأ أثناء حفظ الرمز:', error);
                    });
                })
                .catch((err) => {
                    console.warn('تعذر الحصول على صلاحية الإشعارات أو رمز الجهاز:', err);
                });

            // قاموس الترجمات للواجهة الأمامية لترجمة الإشعارات اللحظية تلقائياً
            window.translations = {
                new_task_notification_title: "{{ __('messages.new_task_notification_title') }}",
                new_task_notification_body: "{{ __('messages.new_task_notification_body', ['title' => '{title}']) }}",
                task_created_by_employee_title: "{{ __('messages.task_created_by_employee_title') }}",
                task_created_by_employee_body: "{{ __('messages.task_created_by_employee_body', ['name' => '{name}', 'title' => '{title}']) }}",
            };

            // التعامل مع الإشعارات والموقع مفتوح في الواجهة (Foreground)
            messaging.onMessage((payload) => {
                console.log('تم استقبال إشعار في الواجهة:', payload);
                
                let title = payload.notification?.title;
                let body = payload.notification?.body;
                
                const data = payload.data || {};
                
                // تحقق أمني لمنع عرض الإشعار لمستخدم غير مستهدف (حتى لو كانت الرموز متداخلة)
                const currentUserId = "{{ Auth::id() }}";
                if (data.recipient_id && data.recipient_id !== currentUserId) {
                    console.log('تم تجاهل الإشعار لأنه غير موجه للمستخدم الحالي.');
                    return;
                }

                if (data.title_key) {
                    const key = data.title_key.replace('messages.', '');
                    if (window.translations && window.translations[key]) {
                        title = window.translations[key];
                    }
                }
                if (data.body_key) {
                    const key = data.body_key.replace('messages.', '');
                    if (window.translations && window.translations[key]) {
                        let translatedBody = window.translations[key];
                        if (data.body_replace_title) {
                            translatedBody = translatedBody.replaceAll('{title}', data.body_replace_title);
                        }
                        if (data.body_replace_name) {
                            translatedBody = translatedBody.replaceAll('{name}', data.body_replace_name);
                        }
                        body = translatedBody;
                    }
                }

                // إظهار التنبيه الاحترافي الجذاب فقط داخل الموقع دون تكرار
                showCustomToast(title, body, data.task_id);

                // إظهار إشعار النظام الافتراضي للمتصفح أيضاً في نفس الوقت
                if (Notification.permission === 'granted') {
                    try {
                        new Notification(title, {
                            body: body,
                            icon: '/favicon.ico'
                        });
                    } catch (e) {
                        console.warn('تعذر عرض إشعار النظام في الواجهة:', e);
                    }
                }

                // تحديث مركز الإشعارات (الجرس) تلقائياً في الخلفية
                fetchNotifications();
            });

            function showCustomToast(title, body, taskId) {
                const container = document.getElementById('custom-toast-container');
                if (!container) return;

                // إضافة أنيميشن النبض لصفحة الهيد إذا لم يكن موجوداً
                if (!document.getElementById('toast-pulse-animation')) {
                    const style = document.createElement('style');
                    style.id = 'toast-pulse-animation';
                    style.innerHTML = `
                        @keyframes toast-pulse {
                            0% { transform: scale(0.95); opacity: 1; }
                            50% { transform: scale(1.3); opacity: 0; }
                            100% { transform: scale(0.95); opacity: 0; }
                        }
                    `;
                    document.head.appendChild(style);
                }

                const isRtl = document.dir === 'rtl';
                const toast = document.createElement('div');
                toast.style.cssText = `
                    background: rgba(30, 41, 59, 0.95);
                    backdrop-filter: blur(16px);
                    -webkit-backdrop-filter: blur(16px);
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    border-left: ${isRtl ? 'none' : '4px solid #6366f1'};
                    border-right: ${isRtl ? '4px solid #6366f1' : 'none'};
                    color: #f8fafc;
                    padding: 16px;
                    border-radius: 16px;
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
                    width: 350px;
                    pointer-events: auto;
                    transform: translateX(${isRtl ? '-380px' : '380px'});
                    transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
                    opacity: 0;
                    display: flex;
                    gap: 12px;
                    position: relative;
                `;

                let viewLink = '';
                if (taskId) {
                    const linkText = isRtl ? 'عرض التفاصيل 🔍' : 'View Details 🔍';
                    viewLink = `<a href="/tasks/${taskId}" class="btn btn-sm btn-primary mt-1" style="font-weight: 600; width: fit-content; border-radius: 8px; padding: 5px 14px; font-size: 0.78rem; background-color: #6366f1; border: none; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);">${linkText}</a>`;
                }

                const closeBtnHtml = `<button onclick="this.closest('[style*=\\'pointer-events: auto\\']').remove()" style="position: absolute; top: 12px; right: ${isRtl ? 'auto' : '12px'}; left: ${isRtl ? '12px' : 'auto'}; background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.1rem; line-height: 1; padding: 0;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">&times;</button>`;

                toast.innerHTML = `
                    <!-- أيقونة الجرس متفاعلة النبض -->
                    <div style="flex-shrink: 0; position: relative; width: 38px; height: 38px; background: rgba(99, 102, 241, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                        <span style="position: absolute; width: 100%; height: 100%; border-radius: 50%; background: rgba(99, 102, 241, 0.4); animation: toast-pulse 2s infinite;"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="z-index: 1;">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>

                    <!-- النصوص -->
                    <div style="flex-grow: 1; display: flex; flex-direction: column; gap: 4px; ${isRtl ? 'text-align: right; padding-left: 10px;' : 'text-align: left; padding-right: 10px;'}">
                        <div style="display: flex; justify-content: space-between; align-items: baseline;">
                            <span style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6366f1; font-weight: 700;">
                                ${isRtl ? 'إشعار جديد' : 'New Notification'}
                            </span>
                            <span style="font-size: 0.68rem; color: #94a3b8;">${isRtl ? 'الآن' : 'Just now'}</span>
                        </div>
                        <h4 style="margin: 0; font-size: 0.92rem; font-weight: 600; color: #ffffff;">${title}</h4>
                        <p style="margin: 0 0 4px 0; font-size: 0.8rem; color: #cbd5e1; line-height: 1.4;">${body}</p>
                        ${viewLink}
                    </div>
                    ${closeBtnHtml}
                `;

                container.appendChild(toast);

                // حركة الظهور
                requestAnimationFrame(() => {
                    toast.style.transform = 'translateX(0)';
                    toast.style.opacity = '1';
                });

                // الاختفاء التلقائي بعد 30 ثانية
                setTimeout(() => {
                    toast.style.transform = `translateX(${isRtl ? '-380px' : '380px'})`;
                    toast.style.opacity = '0';
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 15000);
            }

            // تعليم إشعار واحد كمقروء دون مغادرة الصفحة
            window.markSingleAsRead = function(event, id) {
                if (event) {
                    event.stopPropagation();
                    event.preventDefault();
                }
                axios.post(`/notifications/${id}/read`)
                    .then(() => {
                        fetchNotifications();
                        // إذا كنا بصفحة الأرشيف، نحدثها أيضاً
                        if (window.location.pathname.includes('/notifications/history')) {
                            window.location.reload();
                        }
                    })
                    .catch(err => console.error('Error marking notification as read:', err));
            };

            // جلب الإشعارات من قاعدة البيانات وتحديث الواجهة
            function fetchNotifications() {
                axios.get('/notifications')
                    .then(response => {
                        const notifications = response.data.notifications;
                        const unreadCount = response.data.unread_count;

                        // تحديث شارة العدد الأحمر
                        const badge = document.getElementById('notificationBadge');
                        if (unreadCount > 0) {
                            badge.textContent = unreadCount;
                            badge.classList.remove('d-none');
                        } else {
                            badge.classList.add('d-none');
                        }

                        // تحديث القائمة المنسدلة
                        const list = document.getElementById('notificationList');
                        list.innerHTML = '';

                        const isRtl = document.dir === 'rtl';

                        if (notifications.length === 0) {
                            list.innerHTML = `
                                <div class="p-4 text-center text-secondary small">
                                    ${isRtl ? 'لا توجد إشعارات حالياً' : 'No notifications found'}
                                </div>
                            `;
                            return;
                        }

                        notifications.forEach(notification => {
                            const isUnread = !notification.read_at;
                            const bgColor = isUnread ? 'rgba(99, 102, 241, 0.05)' : 'rgba(241, 245, 249, 0.4)';
                            const titleColor = isUnread ? '#1e293b' : '#475569';
                            const taskId = notification.data.task_id;

                            // نقطة الإشعار غير المقروء الزرقاء المضيئة، أو علامة الصح للإشعار المقروء
                            const unreadDot = isUnread 
                                ? `<span style="width: 8px; height: 8px; background-color: #6366f1; border-radius: 50%; display: inline-block; flex-shrink: 0; box-shadow: 0 0 6px #6366f1;"></span>` 
                                : '';

                            // زر تعليم الإشعار كمقروء بشكل منفرد
                            const markReadBtn = isUnread
                                ? `<button onclick="markSingleAsRead(event, '${notification.id}')" class="btn btn-sm p-0 border-0 d-flex align-items-center justify-content-center" title="${isRtl ? 'تحديد كمقروء' : 'Mark as read'}" style="width: 20px; height: 20px; border-radius: 50%; color: #6366f1; background: rgba(99, 102, 241, 0.1); cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(99, 102, 241, 0.2)'" onmouseout="this.style.background='rgba(99, 102, 241, 0.1)'">
                                    ✔
                                   </button>`
                                : '';

                            const item = document.createElement('a');
                            item.href = `/tasks/${taskId}`;
                            item.className = 'list-group-item list-group-item-action p-3';
                            item.style.cssText = `
                                background-color: ${bgColor};
                                border-bottom: 1px solid rgba(226, 232, 240, 0.6);
                                transition: background-color 0.2s;
                                display: flex;
                                flex-direction: column;
                                gap: 4px;
                                position: relative;
                                text-align: ${isRtl ? 'right' : 'left'};
                                text-decoration: none;
                            `;

                            item.innerHTML = `
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        ${unreadDot}
                                        <strong style="font-size: 0.85rem; color: ${titleColor}; font-weight: ${isUnread ? '700' : '500'};">
                                            ${notification.data.title}
                                        </strong>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="font-size: 0.68rem; color: #94a3b8; white-space: nowrap; flex-shrink: 0;">
                                            ${new Date(notification.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                        </span>
                                        ${markReadBtn}
                                    </div>
                                </div>
                                <span style="font-size: 0.78rem; color: ${isUnread ? '#475569' : '#64748b'}; line-height: 1.4; padding-${isRtl ? 'right' : 'left'}: 14px;">
                                    ${notification.data.body}
                                </span>
                            `;

                            // عند الضغط على الإشعار، يتم تمييزه كمقروء ثم الانتقال
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                axios.post(`/notifications/${notification.id}/read`)
                                    .then(() => {
                                        window.location.href = `/tasks/${taskId}`;
                                    })
                                    .catch(() => {
                                        window.location.href = `/tasks/${taskId}`;
                                    });
                            });

                            list.appendChild(item);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                    });
            }

            // تحديد كل الإشعارات كمقروءة
            function markAllNotificationsAsRead(event) {
                if (event) event.stopPropagation(); // منع إغلاق القائمة المنسدلة عند الضغط

                axios.post('/notifications/read-all')
                    .then(() => {
                        fetchNotifications();
                    })
                    .catch(error => {
                        console.error('Error marking all as read:', error);
                    });
            }

            // جلب الإشعارات لأول مرة عند تحميل الصفحة وإعداد الانتقال الفوري للموبايل
            document.addEventListener('DOMContentLoaded', function() {
                fetchNotifications();
                
                const bellBtn = document.getElementById('bellDropdown');
                if (bellBtn) {
                    bellBtn.addEventListener('click', function(e) {
                        if (window.innerWidth < 992) {
                            e.preventDefault();
                            e.stopPropagation();
                            window.location.href = "{{ route('notifications.history') }}";
                        }
                    });
                }
            });
        </script>

        <!-- حاوية التوست الأنيقة -->
        <div id="custom-toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Style cursor and custom modal on mobile/small screens
                const style = document.createElement('style');
                style.innerHTML = `
                    @media (max-width: 991.98px) {
                        table tbody tr {
                            cursor: pointer;
                        }
                    }
                    .custom-details-modal-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(15, 23, 42, 0.6);
                        backdrop-filter: blur(4px);
                        z-index: 9999;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        opacity: 0;
                        transition: opacity 0.2s ease-in-out;
                    }
                    .custom-details-modal-card {
                        background: #ffffff;
                        border-radius: 16px;
                        width: 90%;
                        max-width: 500px;
                        max-height: 85%;
                        overflow-y: auto;
                        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                        transform: translateY(20px);
                        transition: transform 0.2s ease-in-out;
                        display: flex;
                        flex-direction: column;
                    }
                    .custom-details-modal-overlay.show {
                        opacity: 1;
                    }
                    .custom-details-modal-overlay.show .custom-details-modal-card {
                        transform: translateY(0);
                    }
                `;
                document.head.appendChild(style);

                document.addEventListener('click', function (e) {
                    // Only trigger on small/medium screens (< 992px)
                    if (window.innerWidth >= 992) return;

                    // Find closest table row
                    const tr = e.target.closest('table tbody tr');
                    if (!tr) return;

                    // Ignore if click is on buttons, inputs, links, dropdowns, etc.
                    if (e.target.closest('a, button, input, select, textarea, label, [role="button"]')) return;

                    const table = tr.closest('table');
                    if (!table) return;

                    // Get columns header names (fallback to empty if not found)
                    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
                    const cells = Array.from(tr.cells);

                    let detailsHtml = '<div class="d-flex flex-column gap-3">';
                    let hasDetails = false;

                    headers.forEach((header, index) => {
                        // Skip actions column
                        if (!header || 
                            header.toLowerCase().includes('action') || 
                            header.includes('العمليات') || 
                            header.includes('الاجراءات') || 
                            header.includes('الإجراءات')) {
                            return;
                        }

                        const cell = cells[index];
                        if (!cell) return;

                        // Get html content (cloned)
                        const contentHtml = cell.innerHTML.trim();
                        // Skip if it's empty
                        if (contentHtml === '') return;

                        hasDetails = true;

                        detailsHtml += `
                            <div class="border-bottom pb-2">
                                <div class="text-secondary small fw-bold mb-1">${header}</div>
                                <div class="text-dark fs-6">${contentHtml}</div>
                            </div>
                        `;
                    });

                    detailsHtml += '</div>';

                    if (!hasDetails) return;

                    // Replicate actions/buttons at the footer of the modal if they exist
                    const actionsCell = tr.querySelector('td[data-label*="Action"], td[data-label*="action"], td[data-label*="العمليات"], td:last-child');
                    let footerHtml = '';
                    if (actionsCell) {
                        // Clone the inner HTML of the actions cell to preserve events/classes
                        footerHtml = actionsCell.innerHTML;
                    }

                    // Check/create modal
                    let overlay = document.getElementById('custom-details-modal');
                    if (!overlay) {
                        overlay = document.createElement('div');
                        overlay.id = 'custom-details-modal';
                        overlay.className = 'custom-details-modal-overlay';
                        overlay.style.display = 'none';
                        overlay.innerHTML = `
                            <div class="custom-details-modal-card p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold text-dark mb-0">📋 ${document.dir === 'rtl' ? 'تفاصيل السجل' : 'Row Details'}</h5>
                                    <button type="button" class="btn-close" id="custom-details-modal-close" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #64748b;">&times;</button>
                                </div>
                                <div id="custom-details-modal-body" class="mb-4" style="flex-grow: 1; overflow-y: auto;"></div>
                                <div id="custom-details-modal-footer" class="d-flex justify-content-center gap-2"></div>
                            </div>
                        `;
                        document.body.appendChild(overlay);

                        const closeModal = () => {
                            overlay.classList.remove('show');
                            setTimeout(() => {
                                overlay.style.display = 'none';
                            }, 200);
                        };

                        overlay.addEventListener('click', function (e) {
                            if (e.target === overlay || e.target.id === 'custom-details-modal-close') {
                                closeModal();
                            }
                        });
                    }

                    document.getElementById('custom-details-modal-body').innerHTML = detailsHtml;
                    document.getElementById('custom-details-modal-footer').innerHTML = footerHtml;

                    overlay.style.display = 'flex';
                    // Trigger reflow to run transition
                    overlay.offsetHeight;
                    overlay.classList.add('show');
                });
            });
        </script>
    </body>
</html>
