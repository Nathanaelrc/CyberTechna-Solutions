<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $pageTitle = trim($__env->yieldContent('title', __('CyberTechna Solutions')));
            $pageDescription = trim($__env->yieldContent('meta_description', __('Auditorías de ciberseguridad, pentesting, cursos y acompañamiento técnico para empresas.')));
            $pageUrl = url()->current();
            $socialImage = asset('brand/cybertechna-share.png');
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('brand/cybertechna-favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('brand/cybertechna-favicon-32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('brand/cybertechna-favicon-16.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('brand/cybertechna-icon-180.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <meta name="theme-color" content="#08111d">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="CyberTechna Solutions">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:url" content="{{ $pageUrl }}">
        <meta property="og:image" content="{{ $socialImage }}">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDescription }}">
        <meta name="twitter:image" content="{{ $socialImage }}">

        <script>
            (() => {
                const savedTheme = localStorage.getItem('ct-theme');
                const theme = savedTheme === 'light' || savedTheme === 'dark' ? savedTheme : 'dark';

                document.documentElement.dataset.theme = theme;
                document.documentElement.style.colorScheme = theme;
            })();
        </script>

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
                --ct-heading: #ffffff;
                --ct-accent: #0bc1ad;
                --ct-accent-soft: #4de2d2;
                --ct-signal: #ffb703;
                --ct-signal-soft: #ffd166;
                --ct-danger: #ff6b6b;
                --ct-page-bg:
                    radial-gradient(circle at top right, rgba(11, 193, 173, 0.16), transparent 24%),
                    radial-gradient(circle at 20% 10%, rgba(255, 183, 3, 0.14), transparent 22%),
                    linear-gradient(160deg, #08111d 0%, #0b1729 48%, #0e1322 100%);
                --ct-header-bg: rgba(8, 17, 29, 0.72);
                --ct-header-border: rgba(159, 189, 218, 0.08);
                --ct-nav-link: rgba(219, 231, 245, 0.84);
                --ct-nav-link-active: #ffffff;
                --ct-ghost-color: #ffffff;
                --ct-ghost-bg: rgba(255, 255, 255, 0.04);
                --ct-ghost-border: rgba(219, 231, 245, 0.22);
                --ct-ghost-hover-bg: rgba(255, 255, 255, 0.12);
                --ct-ghost-hover-border: rgba(219, 231, 245, 0.4);
                --ct-owner-text: #04101a;
                --ct-brand-mark-text: #04101a;
                --ct-link-hover: #aefaf0;
                --ct-input-bg: rgba(5, 14, 23, 0.6);
                --ct-input-bg-focus: rgba(5, 14, 23, 0.85);
                --ct-input-color: #ffffff;
                --ct-input-placeholder: #7d96af;
                --ct-article-copy: #d7e3f0;
                --ct-footer-border: rgba(159, 189, 218, 0.08);
                --ct-navbar-collapse-bg: rgba(8, 17, 29, 0.92);
                --ct-shadow-hero: 0 30px 60px rgba(1, 7, 16, 0.35);
                --ct-shadow-brand: 0 20px 45px rgba(11, 193, 173, 0.28);
                --ct-shadow-owner: 0 18px 35px rgba(11, 193, 173, 0.25);
                --ct-shadow-signal: 0 18px 35px rgba(255, 183, 3, 0.22);
                --ct-theme-chip-bg: rgba(255, 255, 255, 0.04);
                --ct-theme-chip-border: rgba(219, 231, 245, 0.1);
                --ct-theme-chip-icon: #ffffff;
                --ct-kicker-bg: rgba(11, 193, 173, 0.12);
                --ct-kicker-text: #89fff0;
                --ct-kicker-border: rgba(11, 193, 173, 0.22);
                --ct-soft-label: #9ad9d1;
                --ct-status-bg: rgba(11, 193, 173, 0.18);
                --ct-status-text: #8ef8eb;
            }

            html[data-theme='light'] {
                --ct-bg: #eef4fb;
                --ct-surface: rgba(255, 255, 255, 0.82);
                --ct-surface-strong: #ffffff;
                --ct-panel: rgba(246, 250, 255, 0.94);
                --ct-border: rgba(37, 64, 97, 0.12);
                --ct-copy: #14283f;
                --ct-muted: #45627d;
                --ct-heading: #0d2238;
                --ct-page-bg:
                    radial-gradient(circle at top right, rgba(11, 193, 173, 0.12), transparent 28%),
                    radial-gradient(circle at 14% 8%, rgba(255, 183, 3, 0.16), transparent 24%),
                    linear-gradient(180deg, #edf4fb 0%, #f7fbff 48%, #f4f9ff 100%);
                --ct-header-bg: rgba(244, 249, 255, 0.82);
                --ct-header-border: rgba(37, 64, 97, 0.1);
                --ct-nav-link: rgba(13, 34, 56, 0.88);
                --ct-nav-link-active: #0d2238;
                --ct-ghost-color: #10263d;
                --ct-ghost-bg: rgba(255, 255, 255, 0.66);
                --ct-ghost-border: rgba(37, 64, 97, 0.14);
                --ct-ghost-hover-bg: rgba(255, 255, 255, 0.92);
                --ct-ghost-hover-border: rgba(37, 64, 97, 0.24);
                --ct-owner-text: #0d1827;
                --ct-brand-mark-text: #0d1827;
                --ct-link-hover: #085f58;
                --ct-input-bg: rgba(255, 255, 255, 0.88);
                --ct-input-bg-focus: rgba(255, 255, 255, 0.98);
                --ct-input-color: #14304a;
                --ct-input-placeholder: #647d97;
                --ct-article-copy: #21415e;
                --ct-footer-border: rgba(37, 64, 97, 0.1);
                --ct-navbar-collapse-bg: rgba(247, 251, 255, 0.98);
                --ct-shadow-hero: 0 24px 50px rgba(27, 57, 92, 0.08);
                --ct-shadow-brand: 0 16px 35px rgba(11, 193, 173, 0.18);
                --ct-shadow-owner: 0 18px 35px rgba(11, 193, 173, 0.18);
                --ct-shadow-signal: 0 18px 35px rgba(255, 183, 3, 0.16);
                --ct-theme-chip-bg: rgba(255, 255, 255, 0.74);
                --ct-theme-chip-border: rgba(37, 64, 97, 0.14);
                --ct-theme-chip-icon: #10263d;
                --ct-kicker-bg: rgba(11, 193, 173, 0.16);
                --ct-kicker-text: #0e6860;
                --ct-kicker-border: rgba(11, 193, 173, 0.3);
                --ct-soft-label: #1a8379;
                --ct-status-bg: rgba(11, 193, 173, 0.18);
                --ct-status-text: #0e6860;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                min-height: 100vh;
                color: var(--ct-copy);
                background: var(--ct-page-bg);
                font-family: 'Manrope', sans-serif;
                overflow-x: clip;
                transition: background 0.35s ease, color 0.35s ease;
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
                background: var(--ct-header-bg);
                border-bottom: 1px solid var(--ct-header-border);
                transition: background 0.35s ease, border-color 0.35s ease;
            }

            .brand-lockup {
                display: inline-flex;
                align-items: center;
                gap: 0.85rem;
                color: var(--ct-heading);
                font-weight: 700;
                letter-spacing: 0.01em;
                max-width: 100%;
                min-width: 0;
                transition: color 0.35s ease;
            }

            .brand-lockup:hover {
                color: var(--ct-heading);
            }

            .brand-wordmark {
                min-width: 0;
                line-height: 1.08;
                white-space: normal;
                text-wrap: balance;
            }

            .brand-mark {
                width: 2.7rem;
                height: 2.7rem;
                display: block;
                border-radius: 0.9rem;
                object-fit: cover;
                flex: 0 0 auto;
                box-shadow: var(--ct-shadow-brand);
            }

            .auth-lockup,
            .footer-lockup {
                display: inline-flex;
                align-items: center;
                gap: 1rem;
            }

            .auth-mark {
                display: block;
                width: 4.75rem;
                height: 4.75rem;
                border-radius: 1.35rem;
                box-shadow: 0 18px 42px rgba(1, 7, 16, 0.28);
            }

            .auth-lockup-title,
            .footer-title {
                color: var(--ct-heading);
                font-family: 'Sora', sans-serif;
                font-weight: 700;
                letter-spacing: 0.01em;
                line-height: 1.05;
                margin: 0;
            }

            .auth-lockup-title {
                font-size: clamp(1.4rem, 3vw, 1.9rem);
            }

            .footer-mark {
                display: block;
                width: 3.35rem;
                height: 3.35rem;
                border-radius: 1rem;
                box-shadow: 0 16px 34px rgba(1, 7, 16, 0.24);
            }

            .footer-title {
                display: block;
                margin-bottom: 0.25rem;
            }

            .navbar .nav-link {
                color: var(--ct-nav-link);
                font-weight: 600;
                transition: color 0.35s ease;
            }

            .navbar .nav-link:hover,
            .navbar .nav-link:focus {
                color: var(--ct-nav-link-active);
            }

            .navbar .nav-link.active {
                color: var(--ct-nav-link-active);
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
                color: var(--ct-ghost-color);
                border-color: var(--ct-ghost-border);
                background: var(--ct-ghost-bg);
            }

            .btn-ghost:hover {
                color: var(--ct-ghost-color);
                background: var(--ct-ghost-hover-bg);
                border-color: var(--ct-ghost-hover-border);
            }

            .btn-owner {
                color: var(--ct-owner-text);
                border-color: transparent;
                background: linear-gradient(135deg, var(--ct-accent), #6df2d9);
                box-shadow: var(--ct-shadow-owner);
            }

            .btn-owner:hover {
                color: var(--ct-owner-text);
                background: linear-gradient(135deg, #21d2be, #7cf5df);
            }

            .btn-signal {
                color: var(--ct-owner-text);
                border-color: transparent;
                background: linear-gradient(135deg, var(--ct-signal), var(--ct-signal-soft));
                box-shadow: var(--ct-shadow-signal);
            }

            .btn-signal:hover {
                color: var(--ct-owner-text);
                background: linear-gradient(135deg, #ffc947, #ffe08a);
            }

            .btn-ghost,
            .btn-owner,
            .btn-signal,
            .hero-card,
            .service-card,
            .frame-card,
            .metric-pill,
            .article-card,
            .owner-banner,
            .contact-form .form-control,
            .contact-form .form-select,
            .site-header,
            .footer-shell,
            .brand-lockup,
            .navbar .nav-link,
            .text-white,
            .article-body {
                transition: background 0.35s ease, border-color 0.35s ease, color 0.35s ease, box-shadow 0.35s ease;
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
                background: var(--ct-kicker-bg);
                color: var(--ct-kicker-text);
                border: 1px solid var(--ct-kicker-border);
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
                box-shadow: var(--ct-shadow-hero);
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
                background: var(--ct-status-bg);
                color: var(--ct-status-text);
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
                color: var(--ct-heading);
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
                color: var(--ct-copy);
            }

            .hero-card ul,
            .frame-card ul {
                color: var(--ct-copy);
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
                color: var(--ct-heading);
                text-decoration: none;
            }

            .article-card a:hover {
                color: var(--ct-link-hover);
            }

            .soft-label {
                color: var(--ct-soft-label);
                letter-spacing: 0.08em;
                text-transform: uppercase;
                font-size: 0.78rem;
                font-weight: 800;
            }

            .section-heading,
            .hero-title,
            .hero-card strong,
            .frame-card strong,
            .owner-banner strong {
                color: var(--ct-heading);
            }

            .contact-form .form-control,
            .contact-form .form-select {
                border-radius: 1rem;
                padding: 0.95rem 1rem;
                border: 1px solid rgba(159, 189, 218, 0.16);
                background: var(--ct-input-bg);
                color: var(--ct-input-color);
            }

            .contact-form .form-control::placeholder {
                color: var(--ct-input-placeholder);
            }

            .contact-form .form-control:focus,
            .contact-form .form-select:focus {
                background: var(--ct-input-bg-focus);
                color: var(--ct-input-color);
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
                border-top: 1px solid var(--ct-footer-border);
            }

            .footer-layout {
                display: grid;
                grid-template-columns: minmax(0, 1.8fr) minmax(16rem, 22rem);
                gap: 2rem;
                align-items: center;
            }

            .footer-branding {
                min-width: 0;
            }

            .footer-copy {
                display: block;
                max-width: 52rem;
                line-height: 1.7;
            }

            .footer-meta {
                display: grid;
                gap: 0.35rem;
                justify-items: end;
                text-align: right;
            }

            .article-body {
                color: var(--ct-article-copy);
                line-height: 1.85;
                white-space: pre-line;
            }

            .utility-switchers {
                display: flex;
                flex-wrap: wrap;
                gap: 0.55rem;
                align-items: center;
            }

            .theme-switcher {
                display: inline-flex;
                align-items: center;
                gap: 0.28rem;
                padding: 0.2rem;
                border-radius: 999px;
                background: var(--ct-theme-chip-bg);
                border: 1px solid var(--ct-theme-chip-border);
                backdrop-filter: blur(14px);
            }

            .theme-switcher .btn {
                min-width: 3.15rem;
            }

            .theme-switcher .btn svg {
                width: 0.95rem;
                height: 0.95rem;
                color: var(--ct-theme-chip-icon);
            }

            .theme-switcher .btn span {
                line-height: 1;
            }

            html[data-theme='light'] .text-white {
                color: var(--ct-heading) !important;
            }

            html[data-theme='light'] .navbar {
                --bs-navbar-color: var(--ct-nav-link);
                --bs-navbar-hover-color: var(--ct-nav-link-active);
                --bs-navbar-active-color: var(--ct-nav-link-active);
                --bs-navbar-brand-color: var(--ct-heading);
                --bs-navbar-brand-hover-color: var(--ct-heading);
                --bs-navbar-toggler-border-color: rgba(37, 64, 97, 0.16);
                --bs-navbar-toggler-icon-bg: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2816,36,58,0.82%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
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
                .navbar-collapse {
                    margin-top: 0.9rem;
                    padding: 1rem 1.1rem;
                    border: 1px solid rgba(159, 189, 218, 0.12);
                    border-radius: 1.35rem;
                    background: var(--ct-navbar-collapse-bg);
                }

                .nav-owner-actions {
                    margin-top: 1rem;
                }

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
                    width: 2.35rem;
                    height: 2.35rem;
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

                .utility-switchers {
                    width: 100%;
                }

                .theme-switcher,
                .utility-switchers .btn-group {
                    width: 100%;
                }

                .theme-switcher .btn,
                .utility-switchers .btn-group .btn {
                    flex: 1 1 0;
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

                .footer-layout {
                    grid-template-columns: 1fr;
                    gap: 1.25rem;
                    align-items: start;
                }

                .footer-meta {
                    justify-items: start;
                    text-align: left;
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
            <nav class="navbar navbar-expand-xl py-3">
                <div class="container">
                    <a class="navbar-brand brand-lockup" href="{{ route('home') }}">
                        <img src="{{ asset('brand/cybertechna-mark.svg') }}" alt="CyberTechna Solutions" class="brand-mark">
                        <span class="brand-wordmark">CyberTechna Solutions</span>
                    </a>

                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="primaryNav">
                        <ul class="navbar-nav ms-auto mb-3 mb-lg-0 gap-lg-2">
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">{{ __('Servicios') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('method') ? 'active' : '' }}" href="{{ route('method') }}">{{ __('Método') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('courses*') || request()->routeIs('portal.courses.*') ? 'active' : '' }}" href="{{ route('courses') }}">{{ __('Cursos') }}</a></li>
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contacto') }}</a></li>
                        </ul>

                        <div class="nav-owner-actions d-flex flex-column flex-lg-row gap-2 ms-lg-3 align-items-lg-center">
                            <div class="utility-switchers">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Language switcher">
                                    <a href="{{ route('locale.switch', ['locale' => 'es']) }}" class="btn {{ app()->getLocale() === 'es' ? 'btn-owner' : 'btn-ghost' }}">ES</a>
                                    <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="btn {{ app()->getLocale() === 'en' ? 'btn-owner' : 'btn-ghost' }}">EN</a>
                                </div>

                                <div class="theme-switcher" data-theme-switcher role="group" aria-label="{{ __('Selector de tema') }}">
                                    <button type="button" class="btn btn-sm btn-ghost d-inline-flex align-items-center justify-content-center gap-2" data-theme-option="light" aria-pressed="false">
                                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M12 3V5.25M12 18.75V21M5.636 5.636L7.227 7.227M16.773 16.773L18.364 18.364M3 12H5.25M18.75 12H21M5.636 18.364L7.227 16.773M16.773 7.227L18.364 5.636M15.75 12A3.75 3.75 0 1 1 8.25 12A3.75 3.75 0 0 1 15.75 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ __('Claro') }}</span>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-ghost d-inline-flex align-items-center justify-content-center gap-2" data-theme-option="dark" aria-pressed="true">
                                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M21 12.79A8.99 8.99 0 0 1 11.21 3C11.07 3 10.94 3.01 10.8 3.02A9 9 0 1 0 20.98 13.2C20.99 13.06 21 12.93 21 12.79Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ __('Oscuro') }}</span>
                                    </button>
                                </div>
                            </div>
                            @auth
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-owner">{{ __('Panel privado') }}</a>
                                @else
                                    <a href="{{ route('portal.courses.index') }}" class="btn btn-owner">{{ __('Mis cursos') }}</a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-ghost w-100">{{ __('Cerrar sesión') }}</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Iniciar sesión') }}</a>
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
            <div class="container footer-layout">
                <div class="footer-branding">
                    <div class="footer-lockup mb-3">
                        <img src="{{ asset('brand/cybertechna-mark.svg') }}" alt="CyberTechna Solutions" class="footer-mark">
                        <strong class="footer-title">CyberTechna Solutions</strong>
                    </div>
                    <span class="footer-copy">{{ __('Auditorías, pentesting, formación y acompañamiento para equipos que no quieren improvisar su seguridad.') }}</span>
                </div>
                <div class="footer-copy footer-meta">
                    <div>{{ __('Contacto: contacto@cybertechna.local') }}</div>
                    <div>{{ __('Desarrollado con Laravel, Bootstrap y Docker.') }}</div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            (() => {
                const root = document.documentElement;
                const switcher = document.querySelector('[data-theme-switcher]');

                if (! switcher) {
                    return;
                }

                const buttons = [...switcher.querySelectorAll('[data-theme-option]')];

                const applyTheme = (theme) => {
                    root.dataset.theme = theme;
                    root.style.colorScheme = theme;
                    localStorage.setItem('ct-theme', theme);

                    buttons.forEach((button) => {
                        const isActive = button.dataset.themeOption === theme;

                        button.classList.toggle('btn-owner', isActive);
                        button.classList.toggle('btn-ghost', ! isActive);
                        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                    });
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => applyTheme(button.dataset.themeOption));
                });

                applyTheme(root.dataset.theme === 'light' ? 'light' : 'dark');
            })();
        </script>
        @stack('scripts')
    </body>
</html>