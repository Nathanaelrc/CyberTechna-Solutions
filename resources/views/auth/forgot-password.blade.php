@extends('layouts.site')

@section('title', __('Recuperar contraseña').' | CyberTechna Solutions')

@section('content')
    <section class="section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="frame-card">
                        <div class="auth-lockup mb-4">
                            <img src="{{ asset('brand/cybertechna-mark.svg') }}" alt="CyberTechna Solutions" class="auth-mark">
                            <strong class="auth-lockup-title">CyberTechna Solutions</strong>
                        </div>

                        <span class="eyebrow">{{ __('Recuperación') }}</span>
                        <h1 class="h2 text-white mt-3 mb-3">{{ __('¿Olvidaste tu contraseña?') }}</h1>
                        <p class="section-copy mb-4">{{ __('Escribe tu correo y te enviaremos un enlace para crear una nueva contraseña.') }}</p>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-owner w-100">{{ __('Enviar enlace de recuperación') }}</button>
                        </form>

                        <a href="{{ route('login') }}" class="btn btn-ghost w-100 mt-3">{{ __('Volver al inicio de sesión') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
