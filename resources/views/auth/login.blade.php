@extends('layouts.site')

@section('title', __('Iniciar sesión').' | CyberTechna Solutions')

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
                        <span class="eyebrow">{{ __('Acceso') }}</span>
                        <h1 class="h2 text-white mt-3 mb-3">{{ __('Accede con tu cuenta para entrar al panel o ver el catálogo de cursos.') }}</h1>
                        <p class="section-copy mb-4">{{ __('Los administradores pueden gestionar contenido y usuarios. Las cuentas normales acceden a su catálogo de cursos y a los enlaces de clase disponibles.') }}</p>

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" @checked(old('remember'))>
                                <label class="form-check-label" for="remember">{{ __('Mantener sesión iniciada') }}</label>
                            </div>

                            <button type="submit" class="btn btn-owner w-100">{{ __('Entrar') }}</button>
                        </form>

                        <a href="{{ route('password.request') }}" class="btn btn-ghost w-100 mt-3">{{ __('Olvidé mi contraseña') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection