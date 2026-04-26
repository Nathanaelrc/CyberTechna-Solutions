<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', __('CyberTechna Solutions'))</title>
        <meta name="description" content="@yield('meta_description', __('Auditorias de ciberseguridad, pentesting, cursos y acompanamiento tecnico para empresas.'))">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
            :root {
                --ct-bg: #08111d;
                --ct-surface: rgba(12, 26, 43, 0.82);
                --ct-surface-strong: #0e1d31;
                --ct-panel: rgba(22, 38, 62, 0.84);
                --ct-border: rgba(159, 189, 218, 0.18);
                --ct-copy: #dbe7f5;
                --ct-muted: #8ea4bc;
                --ct-accent: #0bc1ad;
                --ct-signal: #ffb703;
                --ct-danger: #ff6b6b;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                min-height: 100vh;
                color: var(--ct-copy);
                background:
                    radial-gradient(circle at top right, rgba(11, 193, 173, 0.16), transparent 24%),
                    radial-gradient(circle at 20% 10%, rgba(255, 183, 3, 0.14), transparent 22%),
                    linear-gradient(160deg, #08111d 0%, #0b1729 48%, #0e1322 100%);
                font-family: 'Manrope', sans-serif;
                overflow-x: clip;
            }

            .container {
                --bs-gutter-x: clamp(1.35rem, 3vw, 2.6rem);
            }

            h1,
            h2,
            h3,
            h4,
            .navbar-brand,
            .display-4,
            .display-5 {
                font-family: 'Sora', sans-serif;
            }

            .site-header {
                position: sticky;
                top: 0;
                z-index: 1030;
                backdrop-filter: blur(18px);
                background: rgba(8, 17, 29, 0.72);
                border-bottom: 1px solid rgba(159, 189, 218, 0.08);
            }

            .brand-lockup {
                display: inline-flex;
                align-items: center;
                gap: 0.85rem;
                color: #fff;
                font-weight: 700;
                letter-spacing: 0.01em;
                max-width: 100%;
                min-width: 0;
            }

            .brand-lockup:hover {
                color: #fff;
            }

            .brand-lockup span:last-child {
                min-width: 0;
                line-height: 1.08;
                white-space: normal;
                text-wrap: balance;
            }

            .brand-mark {
                width: 2.5rem;
                height: 2.5rem;
                display: inline-grid;
                place-items: center;
                border-radius: 0.9rem;
                background: linear-gradient(135deg, var(--ct-accent), #4de2d2);
                color: #04101a;
                font-size: 0.92rem;
                box-shadow: 0 20px 45px rgba(11, 193, 173, 0.28);
            }

            .navbar .nav-link {
                color: rgba(219, 231, 245, 0.84);
                font-weight: 600;
            }

            .navbar .nav-link:hover,
            .navbar .nav-link:focus {
                color: #fff;
            }

            .navbar .nav-link.active {
                color: #fff;
            }

            .btn-ghost,
            .btn-owner,
            .btn-signal {
                border-radius: 999px;
                padding: 0.82rem 1.3rem;
                font-weight: 700;
                border-width: 1px;
            }

            .btn-ghost {
                color: #fff;
                border-color: rgba(219, 231, 245, 0.22);
                background: rgba(255, 255, 255, 0.04);
            }

            .btn-ghost:hover {
                color: #fff;
                background: rgba(255, 255, 255, 0.12);
                border-color: rgba(219, 231, 245, 0.4);
            }

            .btn-owner {
                color: #04101a;
                border-color: transparent;
                background: linear-gradient(135deg, var(--ct-accent), #6df2d9);
                box-shadow: 0 18px 35px rgba(11, 193, 173, 0.25);
            }

            .btn-owner:hover {
                color: #04101a;
                background: linear-gradient(135deg, #21d2be, #7cf5df);
            }

            .btn-signal {
                color: #09111c;
                border-color: transparent;
                background: linear-gradient(135deg, var(--ct-signal), #ffd166);
                box-shadow: 0 18px 35px rgba(255, 183, 3, 0.22);
            }

            .btn-signal:hover {
                color: #09111c;
                background: linear-gradient(135deg, #ffc947, #ffe08a);
            }

            .section-space {
                padding: 5.5rem 0;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 0.7rem;
                padding: 0.45rem 0.9rem;
                border-radius: 999px;
                font-size: 0.82rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                background: rgba(11, 193, 173, 0.12);
                color: #89fff0;
                border: 1px solid rgba(11, 193, 173, 0.22);
            }

            .hero-title {
                font-size: clamp(2.3rem, 5.5vw, 4.9rem);
                line-height: 0.98;
                margin-top: 1.35rem;
                margin-bottom: 1.35rem;
                max-width: 13ch;
                text-wrap: balance;
            }

            .hero-copy,
            .section-copy,
            .card-copy {
                color: var(--ct-muted);
                font-size: clamp(0.98rem, 1.05vw, 1.08rem);
                line-height: 1.75;
            }

            .section-copy,
            .card-copy {
                max-width: 64ch;
            }

            .hero-card,
            .service-card,
            .frame-card,
            .metric-pill,
            .article-card,
            .owner-banner {
                border: 1px solid var(--ct-border);
                background: var(--ct-surface);
                backdrop-filter: blur(16px);
            }

            .hero-card {
                border-radius: 2rem;
                padding: 2rem;
                box-shadow: 0 30px 60px rgba(1, 7, 16, 0.35);
            }

            .hero-grid {
                display: grid;
                gap: 1rem;
            }

            .status-line {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid rgba(159, 189, 218, 0.12);
            }

            .status-line:last-child {
                border-bottom: 0;
                padding-bottom: 0;
            }

            .status-index {
                width: 2.25rem;
                height: 2.25rem;
                display: inline-grid;
                place-items: center;
                border-radius: 999px;
                background: rgba(11, 193, 173, 0.18);
                color: #8ef8eb;
                font-weight: 800;
            }

            .metric-pill {
                border-radius: 1.2rem;
                padding: 1rem 1.1rem;
                min-width: 0;
            }

            .metric-pill strong {
                display: block;
                font-size: 1.65rem;
                color: #fff;
            }

            .service-card,
            .article-card,
            .frame-card,
            .owner-banner {
                border-radius: 1.75rem;
                padding: 1.6rem;
                height: 100%;
            }

            .service-card ul {
                padding-left: 1rem;
                color: var(--ct-muted);
            }

            .service-card li + li {
                margin-top: 0.75rem;
            }

            .signal-bar {
                width: 4.4rem;
                height: 0.32rem;
                border-radius: 999px;
                background: linear-gradient(90deg, var(--ct-accent), var(--ct-signal));
                margin-bottom: 1rem;
            }

            .section-heading {
                font-size: clamp(1.9rem, 3vw, 3rem);
                margin-bottom: 1rem;
                max-width: 15ch;
                text-wrap: balance;
            }

            .hero-card h2,
            .service-card h3,
            .article-card h3,
            .frame-card h3,
            .frame-card h2 {
                text-wrap: balance;
            }

            .article-card a {
                color: #fff;
                text-decoration: none;
            }

            .article-card a:hover {
                color: #aefaf0;
            }

            .soft-label {
                color: #9ad9d1;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                font-size: 0.78rem;
                font-weight: 800;
            }

            .contact-form .form-control,
            .contact-form .form-select {
                border-radius: 1rem;
                padding: 0.95rem 1rem;
                border: 1px solid rgba(159, 189, 218, 0.16);
                background: rgba(5, 14, 23, 0.6);
                color: #fff;
            }

            .contact-form .form-control::placeholder {
                color: #7d96af;
            }

            .contact-form .form-control:focus,
            .contact-form .form-select:focus {
                background: rgba(5, 14, 23, 0.85);
                color: #fff;
                box-shadow: 0 0 0 0.25rem rgba(11, 193, 173, 0.16);
                border-color: rgba(11, 193, 173, 0.42);
            }

            .form-note,
            .footer-copy {
                color: var(--ct-muted);
            }

            .owner-banner {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                background: linear-gradient(135deg, rgba(11, 193, 173, 0.18), rgba(255, 183, 3, 0.08));
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.9rem;
            }

            .metrics-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.9rem;
                margin-top: 1.5rem;
            }

            .nav-owner-actions {
                align-items: stretch;
            }

            .contact-form-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }

            .footer-shell {
                padding: 1.7rem 0 2.4rem;
                border-top: 1px solid rgba(159, 189, 218, 0.08);
            }

            .article-body {
                color: #d7e3f0;
                line-height: 1.85;
                white-space: pre-line;
            }

            @media (min-width: 1600px) {
                .container {
                    max-width: min(1480px, calc(100vw - 7rem));
                }

                .section-space {
                    padding: 6.25rem 0;
                }
            }

            @media (max-width: 1199.98px) {
                .metrics-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .metrics-grid .metric-pill:last-child {
                    grid-column: 1 / -1;
                }
            }

            @media (max-width: 991.98px) {
                .section-space {
                    padding: 4.25rem 0;
                }

                .navbar-collapse {
                    margin-top: 0.9rem;
                    padding: 1rem 1.1rem;
                    border: 1px solid rgba(159, 189, 218, 0.12);
                    border-radius: 1.35rem;
                    background: rgba(8, 17, 29, 0.92);
                }

                .nav-owner-actions {
                    margin-top: 1rem;
                }

                .hero-card,
                .service-card,
                .frame-card,
                .metric-pill,
                .article-card,
                .owner-banner {
                    padding: 1.35rem;
                    border-radius: 1.4rem;
                }

                .owner-banner {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }

            @media (max-width: 767.98px) {
                .brand-lockup {
                    max-width: calc(100% - 4.2rem);
                    gap: 0.7rem;
                    font-size: 0.98rem;
                }

                .brand-mark {
                    width: 2.2rem;
                    height: 2.2rem;
                    border-radius: 0.8rem;
                    flex: 0 0 auto;
                }

                .hero-title {
                    font-size: clamp(2.05rem, 8.5vw, 3rem);
                    line-height: 1.02;
                    max-width: 11ch;
                }

                .section-heading {
                    font-size: clamp(1.7rem, 7vw, 2.35rem);
                    max-width: 12ch;
                }

                .eyebrow,
                .soft-label {
                    letter-spacing: 0.06em;
                }

                .hero-copy,
                .section-copy,
                .card-copy,
                .form-note,
                .footer-copy {
                    font-size: 0.98rem;
                    line-height: 1.68;
                }

                .metrics-grid {
                    grid-template-columns: 1fr;
                }

                .metrics-grid .metric-pill:last-child {
                    grid-column: auto;
                }

                .hero-actions,
                .contact-form-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .hero-actions .btn,
                .contact-form-actions .btn,
                .owner-banner .btn {
                    width: 100%;
                }

                .status-line {
                    gap: 0.85rem;
                    padding: 0.9rem 0;
                }

                .status-index {
                    width: 2rem;
                    height: 2rem;
                    flex: 0 0 auto;
                }

                .footer-shell {
                    padding-top: 1.25rem;
                }
            }

            @media (max-width: 575.98px) {
                .section-space {
                    padding: 3.5rem 0;
                }

                .btn-ghost,
                .btn-owner,
                .btn-signal {
                    padding: 0.85rem 1rem;
                }

                .metric-pill strong {
                    font-size: 1.45rem;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <header class="site-header">
            <nav class="navbar navbar-expand-lg navbar-dark py-3">
                <div class="container">
                    <a class="navbar-brand brand-lockup" href="{{ route('home') }}">
                        <span class="brand-mark">CT</span>
                        <span>CyberTechna Solutions</span>
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="primaryNav">
                        <ul class="navbar-nav ms-auto mb-3 mb-lg-0 gap-lg-2">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">{{ __('Servicios') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('method') ? 'active' : '' }}" href="{{ route('method') }}">{{ __('Metodo') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('courses*') ? 'active' : '' }}" href="{{ route('courses') }}">{{ __('Cursos') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contacto') }}</a></li>
                        </ul>

                        <div class="nav-owner-actions d-flex flex-column flex-lg-row gap-2 ms-lg-3 align-items-lg-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Language switcher">
                                <a href="{{ route('locale.switch', ['locale' => 'es']) }}" class="btn {{ app()->getLocale() === 'es' ? 'btn-owner' : 'btn-ghost' }}">ES</a>
                                <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="btn {{ app()->getLocale() === 'en' ? 'btn-owner' : 'btn-ghost' }}">EN</a>
                            </div>
                            @auth
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-owner">{{ __('Panel privado') }}</a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-ghost w-100">{{ __('Cerrar sesion') }}</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Acceso propietario') }}</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="container pt-4">
                @include('partials.alerts')
            </div>

            @yield('content')
        </main>

        <footer class="footer-shell">
            <div class="container d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <strong class="d-block text-white mb-1">CyberTechna Solutions</strong>
                    <span class="footer-copy">{{ __('Auditorias, pentesting, formacion y acompanamiento para equipos que no quieren improvisar su seguridad.') }}</span>
                </div>
                <div class="footer-copy text-lg-end">
                    <div>{{ __('Contacto: contacto@cybertechna.local') }}</div>
                    <div>{{ __('Desarrollado con Laravel, Bootstrap y Docker.') }}</div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>