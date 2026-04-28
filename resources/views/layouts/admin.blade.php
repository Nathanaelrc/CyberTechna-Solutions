<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Panel | CyberTechna Solutions')</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('brand/cybertechna-favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('brand/cybertechna-favicon-32.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <meta name="theme-color" content="#07111a">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
            :root {
                --admin-bg: #07111a;
                --admin-surface: #0f1d2a;
                --admin-panel: #122436;
                --admin-copy: #d9e4ef;
                --admin-muted: #90a5bc;
                --admin-border: rgba(160, 186, 213, 0.14);
                --admin-accent: #0bc1ad;
                --admin-signal: #ffb703;
            }

            body {
                min-height: 100vh;
                background:
                    radial-gradient(circle at top left, rgba(11, 193, 173, 0.15), transparent 24%),
                    linear-gradient(170deg, #07111a 0%, #0b1727 54%, #0c1322 100%);
                color: var(--admin-copy);
                font-family: 'Manrope', sans-serif;
            }

            h1,
            h2,
            h3,
            h4,
            .navbar-brand {
                font-family: 'Sora', sans-serif;
            }

            .admin-nav {
                background: rgba(7, 17, 26, 0.84);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(160, 186, 213, 0.08);
            }

            .admin-brand {
                display: inline-flex;
                align-items: center;
                gap: 0.8rem;
                color: #fff;
                font-weight: 700;
            }

            .admin-brand:hover {
                color: #fff;
            }

            .admin-brand-mark {
                width: 2.65rem;
                height: 2.65rem;
                object-fit: cover;
                border-radius: 0.95rem;
                flex: 0 0 auto;
                box-shadow: 0 16px 30px rgba(1, 7, 16, 0.32);
            }

            .admin-brand-text {
                display: inline-flex;
                flex-direction: column;
                line-height: 1.02;
            }

            .admin-brand-text small {
                font-family: 'Manrope', sans-serif;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.14em;
                text-transform: uppercase;
                color: var(--admin-muted);
            }

            .admin-shell {
                padding: 2rem 0 4rem;
            }

            .admin-card,
            .admin-stat,
            .table-shell {
                border-radius: 1.45rem;
                border: 1px solid var(--admin-border);
                background: rgba(15, 29, 42, 0.86);
                backdrop-filter: blur(14px);
                box-shadow: 0 20px 48px rgba(1, 7, 16, 0.28);
            }

            .admin-card,
            .table-shell {
                padding: 1.5rem;
            }

            .admin-stat {
                padding: 1.4rem;
                height: 100%;
            }

            .admin-stat strong {
                display: block;
                font-size: 2rem;
                color: #fff;
                margin-top: 0.4rem;
            }

            .muted {
                color: var(--admin-muted);
            }

            .admin-link,
            .btn-admin,
            .btn-signal-soft {
                border-radius: 999px;
                font-weight: 700;
            }

            .admin-link {
                color: rgba(217, 228, 239, 0.8);
            }

            .admin-link.active,
            .admin-link:hover {
                color: #fff;
            }

            .btn-admin {
                color: #04111a;
                background: linear-gradient(135deg, var(--admin-accent), #6df2d9);
                border: 0;
                padding: 0.8rem 1.2rem;
            }

            .btn-signal-soft {
                color: #111827;
                background: linear-gradient(135deg, var(--admin-signal), #ffd166);
                border: 0;
                padding: 0.75rem 1.15rem;
            }

            .table {
                --bs-table-bg: transparent;
                --bs-table-color: var(--admin-copy);
                --bs-table-border-color: rgba(160, 186, 213, 0.08);
            }

            .table thead th {
                color: #eef5fb;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .form-control,
            .form-select,
            .form-control:focus,
            .form-select:focus {
                border-radius: 1rem;
                background: rgba(5, 14, 23, 0.65);
                color: #fff;
                border-color: rgba(160, 186, 213, 0.18);
            }

            .form-control:focus,
            .form-select:focus {
                box-shadow: 0 0 0 0.25rem rgba(11, 193, 173, 0.16);
                border-color: rgba(11, 193, 173, 0.42);
            }

            .pagination {
                --bs-pagination-bg: transparent;
                --bs-pagination-border-color: rgba(160, 186, 213, 0.14);
                --bs-pagination-color: #d9e4ef;
                --bs-pagination-hover-color: #fff;
                --bs-pagination-hover-bg: rgba(255, 255, 255, 0.06);
                --bs-pagination-active-bg: var(--admin-accent);
                --bs-pagination-active-border-color: var(--admin-accent);
                --bs-pagination-active-color: #04111a;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark admin-nav py-3">
            <div class="container">
                <a class="navbar-brand admin-brand" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('brand/cybertechna-mark.svg') }}" alt="CyberTechna Solutions" class="admin-brand-mark">
                    <span class="admin-brand-text">
                        <span>CyberTechna Solutions</span>
                        <small>Panel</small>
                    </span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="adminNav">
                    <ul class="navbar-nav ms-auto mb-3 mb-lg-0 gap-lg-2 align-items-lg-center">
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">Servicios</a></li>
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">Cursos</a></li>
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Publicaciones</a></li>
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link admin-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">Mensajes</a></li>
                        <li class="nav-item"><a class="nav-link admin-link" href="{{ route('home') }}" target="_blank" rel="noreferrer">Ver sitio</a></li>
                    </ul>

                    <form method="POST" action="{{ route('logout') }}" class="ms-lg-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-light rounded-pill px-4">{{ __('Cerrar sesión') }}</button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="admin-shell">
            <div class="container">
                @include('partials.alerts')
                @yield('content')
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>