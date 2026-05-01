@extends('layouts.site')

@section('title', __('Nueva contraseña').' | CyberTechna Solutions')

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

                        <span class="eyebrow">{{ __('Seguridad') }}</span>
                        <h1 class="h2 text-white mt-3 mb-3">{{ __('Define tu nueva contraseña') }}</h1>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Nueva contraseña') }}</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">{{ __('Confirmar contraseña') }}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required>
                            </div>

                            <button type="submit" class="btn btn-owner w-100">{{ __('Guardar nueva contraseña') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
