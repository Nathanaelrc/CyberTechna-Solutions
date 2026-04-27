@extends('layouts.site')

@section('title', __('Servicios').' | CyberTechna Solutions')
@section('meta_description', __('Auditorías de ciberseguridad, pentesting y acompañamiento continuo para convertir riesgos en planes de acción ejecutables.'))

@section('content')
    @php($auditService = $services->firstWhere('slug', 'auditorias-de-ciberseguridad'))

    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Servicios') }}</span>
                    <h1 class="hero-title">{{ __('Auditorías y servicios de ciberseguridad que explican el riesgo con claridad.') }}</h1>
                    <p class="hero-copy mb-0">{{ __('En CyberTechna Solutions no nos quedamos en enumerar vulnerabilidades. Auditamos tecnología, procesos y exposición real para ayudarte a entender qué afecta al negocio, qué debe corregirse primero y cómo sostener la mejora.') }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="soft-label mb-3">{{ __('Cuando tiene sentido empezar por aquí') }}</div>
                        <div class="status-line">
                            <span class="status-index">1</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Necesitas visibilidad real de tu postura') }}</strong>
                                <span class="form-note">{{ __('Antes de certificar, crecer o responder a clientes exigentes.') }}</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">2</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Quieres validar controles con evidencia') }}</strong>
                                <span class="form-note">{{ __('Con pentesting y revisiones técnicas reproducibles.') }}</span>
                            </div>
                        </div>
                        <div class="status-line">
                            <span class="status-index">3</span>
                            <div>
                                <strong class="d-block text-white mb-1">{{ __('Tu equipo necesita criterio para ejecutar') }}</strong>
                                <span class="form-note">{{ __('Con acompañamiento posterior y transferencia técnica.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">{{ __('Líneas de servicio') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('Cada línea resuelve un tipo de necesidad distinto, pero todas comparten la misma lógica: evidencia, priorización y acompañamiento.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-6">
                        <article class="service-card">
                            <div class="soft-label mb-2">{{ __('Servicio') }} {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $service->title }}</h3>
                            <p class="card-copy mb-3">{{ $service->excerpt }}</p>
                            <p class="card-copy">{{ $service->description }}</p>
                            <ul class="mb-0 mt-4">
                                @foreach ($service->deliverables ?? [] as $deliverable)
                                    <li>{{ $deliverable }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-4 d-flex flex-wrap gap-2">
                                <a href="{{ route('services.show', $service) }}" class="btn btn-ghost">{{ __('Abrir servicio') }}</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($auditService)
        <section class="section-space pt-0">
            <div class="container">
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-lg-7">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading">{{ __('Coberturas de auditoría que solemos ejecutar') }}</h2>
                    </div>
                    <div class="col-lg-5">
                        <p class="section-copy mb-0">{{ __('La auditoría se adapta al activo y al objetivo del cliente. Estas son algunas variantes frecuentes dentro del alcance de ese servicio.') }}</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($auditService->details ?? [] as $detail)
                        <div class="col-lg-6">
                            <div class="frame-card h-100">
                                <div class="soft-label mb-2">{{ __('Auditoría') }} {{ $loop->iteration }}</div>
                                <h3 class="h4 text-white mb-3">{{ $detail }}</h3>
                                <p class="card-copy mb-0">{{ __('Se define alcance, evidencia requerida, criticidad de hallazgos y plan de remediación alineado a negocio y tecnología.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">{{ __('Pentesting y validación ofensiva') }}</div>
                        <h2 class="h3 text-white mb-3">{{ __('Probamos lo que un atacante intentaría explotar.') }}</h2>
                        <p class="card-copy mb-0">{{ __('El pentesting complementa la auditoría: ayuda a confirmar si una debilidad es realmente explotable, qué impacto tendría y qué controles fallan en la práctica.') }}</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        @foreach ($pentestScopes as $scope)
                            <div class="col-md-4">
                                <div class="frame-card h-100">
                                    <div class="soft-label mb-2">{{ __('Alcance') }} {{ $loop->iteration }}</div>
                                    <h3 class="h5 text-white mb-3">{{ $scope['title'] }}</h3>
                                    <p class="card-copy mb-0">{{ $scope['summary'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="owner-banner">
                <div>
                    <div class="soft-label mb-2">{{ __('Qué obtienes al final') }}</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($auditBenefits as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-signal">{{ __('Solicitar propuesta') }}</a>
            </div>
        </div>
    </section>
@endsection