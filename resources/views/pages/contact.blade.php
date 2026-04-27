@extends('layouts.site')

@section('title', __('Contacto').' | CyberTechna Solutions')
@section('meta_description', __('Habla con CyberTechna Solutions sobre auditorías, pentesting, cursos y acompañamiento continuo.'))

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Contacto') }}</span>
                    <h1 class="hero-title">{{ __('Cuánto mejor entendamos tu contexto, mejor definimos el alcance.') }}</h1>
                    <p class="hero-copy mb-0">{{ __('Si buscas una auditoría, un pentest, cursos o acompañamiento continuo, cuéntanos el punto de partida, el tipo de activo y la urgencia. Te responderemos con una propuesta clara y realista.') }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">{{ __('Situaciones comunes') }}</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($contactReasons as $reason)
                                <li class="mb-3">{{ $reason }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="frame-card h-100">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading mb-3">{{ __('Formulario de contacto') }}</h2>
                        <p class="section-copy mb-4">{{ __('El mensaje queda visible en tu panel privado para seguimiento. Si indicas bien el servicio, el tipo de activo y la urgencia, podremos proponerte un alcance más útil desde el primer intercambio.') }}</p>

                        <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Tu nombre') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="tu@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="company" class="form-label">{{ __('Empresa') }}</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" placeholder="{{ __('Nombre de la empresa') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="service" class="form-label">{{ __('Servicio de interés') }}</label>
                                    <select class="form-select" id="service" name="service" required>
                                        <option value="">{{ __('Selecciona un servicio') }}</option>
                                        @foreach ($serviceHighlights as $service)
                                            <option value="{{ $service->title }}" @selected(old('service') === $service->title)>{{ $service->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">{{ __('Contexto') }}</label>
                                    <textarea class="form-control" id="message" name="message" rows="6" placeholder="{{ __('Describe el reto, el alcance, los activos implicados y la urgencia.') }}" required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="contact-form-actions mt-4">
                                <span class="form-note">{{ __('Te responderemos con una ruta inicial, supuestos y siguiente paso recomendado.') }}</span>
                                <button type="submit" class="btn btn-signal">{{ __('Enviar solicitud') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">{{ __('Qué conviene indicarnos') }}</div>
                        <div class="status-line">
                            <span class="status-index">A</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Activo o alcance') }}</strong>
                                <span class="form-note">{{ __('Aplicación, API, red interna, nube, cumplimiento, equipo a formar.') }}</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">B</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Motivo del proyecto') }}</strong>
                                <span class="form-note">{{ __('Cliente, certificación, riesgo interno, hoja de ruta o mejora continua.') }}</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">C</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Urgencia y equipo involucrado') }}</strong>
                                <span class="form-note">{{ __('Esto ayuda a proponer un alcance realista y un formato adecuado.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection