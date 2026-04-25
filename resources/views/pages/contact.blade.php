@extends('layouts.site')

@section('title', 'Contacto | CyberTechna Solutions')
@section('meta_description', 'Habla con CyberTechna Solutions sobre auditorias, pentesting, cursos y acompanamiento continuo.')

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">Contacto</span>
                    <h1 class="hero-title">Cuanto mejor entendamos tu contexto, mejor definimos el alcance.</h1>
                    <p class="hero-copy mb-0">Si buscas una auditoria, un pentest, cursos o acompanamiento continuo, cuentanos el punto de partida, el tipo de activo y la urgencia. Te responderemos con una propuesta clara y realista.</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">Situaciones comunes</div>
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
                        <h2 class="section-heading mb-3">Formulario de contacto</h2>
                        <p class="section-copy mb-4">El mensaje queda visible en tu panel privado para seguimiento. Si indicas bien el servicio, el tipo de activo y la urgencia, podremos proponerte un alcance mas util desde el primer intercambio.</p>

                        <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Tu nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="tu@empresa.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="company" class="form-label">Empresa</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}" placeholder="Nombre de la empresa">
                                </div>
                                <div class="col-md-6">
                                    <label for="service" class="form-label">Servicio de interes</label>
                                    <select class="form-select" id="service" name="service" required>
                                        <option value="">Selecciona un servicio</option>
                                        @foreach ($serviceHighlights as $service)
                                            <option value="{{ $service->title }}" @selected(old('service') === $service->title)>{{ $service->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Contexto</label>
                                    <textarea class="form-control" id="message" name="message" rows="6" placeholder="Describe el reto, el alcance, los activos implicados y la urgencia." required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <div class="contact-form-actions mt-4">
                                <span class="form-note">Te responderemos con una ruta inicial, supuestos y siguiente paso recomendado.</span>
                                <button type="submit" class="btn btn-signal">Enviar solicitud</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">Que conviene indicarnos</div>
                        <div class="status-line">
                            <span class="status-index">A</span>
                            <div>
                                <strong class="d-block text-white mb-1">Activo o alcance</strong>
                                <span class="form-note">Aplicacion, API, red interna, nube, cumplimiento, equipo a formar.</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">B</span>
                            <div>
                                <strong class="d-block text-white mb-1">Motivo del proyecto</strong>
                                <span class="form-note">Cliente, certificacion, riesgo interno, hoja de ruta o mejora continua.</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">C</span>
                            <div>
                                <strong class="d-block text-white mb-1">Urgencia y equipo involucrado</strong>
                                <span class="form-note">Esto ayuda a proponer un alcance realista y un formato adecuado.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection