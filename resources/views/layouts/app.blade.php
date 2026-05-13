<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ site_settings('theme_layout', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nexus RBAC') }}</title>

    <!-- 1. Inject Global Dynamic Settings as CSS Variables -->
    <style>
        :root {
            --brand-orange: {{ site_settings('brand_orange', '#FFA500') }};
            --brand-blue: {{ site_settings('brand_blue', '#214497') }};
            --accent-color: var(--brand-blue);
            --accent-hover: color-mix(in srgb, var(--brand-blue) 85%, black);
            --font-main: '{{ site_settings('font_family', 'Plus Jakarta Sans') }}', sans-serif;
        }
    </style>

    <!-- 2. Pre-load Theme to prevent Flash of Unstyled Content (FOUC) -->
    <script>
        const savedTheme = localStorage.getItem('nexus_theme');
        const defaultTheme = document.documentElement.getAttribute('data-theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (defaultTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="font-inter overflow-x-hidden theme-transition">
    <div id="app" class="d-flex min-vh-100">
        
        @auth
            @include('layouts.partials.sidebar')
        @endauth

        <div id="page-wrapper" class="d-flex flex-column flex-grow-1 {{ !Auth::check() ? 'ms-0' : '' }}">
            
            @include('layouts.partials.topbar')

            <main class="flex-grow-1 p-3 p-md-4 d-flex flex-column">
                
                {{-- Flash Messages --}}
                <div id="flash-alerts" class="w-100">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check me-3 fs-5"></i> 
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4 d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-3 fs-5"></i> 
                            <div>{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>
    
    <!-- Core Application Scripts -->
    <script>
        // 1. Sidebar Toggle Logic
        function toggleSidebar() {
            const body = document.body;
            body.classList.toggle('sidebar-open');
            
            if (window.innerWidth <= 991.98) {
                body.style.overflow = body.classList.contains('sidebar-open') ? 'hidden' : '';
            }
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 991.98 && document.body.classList.contains('sidebar-open')) {
                toggleSidebar();
            }
        });

        // 2. Dark/Light Theme Toggle Logic
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;
            const moonIcon = document.querySelector('.dark-hidden');
            const sunIcon = document.querySelector('.light-hidden');

            function updateIcons(theme) {
                if (theme === 'dark') {
                    moonIcon.style.display = 'none';
                    sunIcon.style.display = 'inline-block';
                } else {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'inline-block';
                }
            }

            updateIcons(html.getAttribute('data-theme'));

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    let currentTheme = html.getAttribute('data-theme');
                    let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    html.setAttribute('data-theme', newTheme);
                    localStorage.setItem('nexus_theme', newTheme);
                    updateIcons(newTheme);
                });
            }
        });
    </script>
</body>
</html>