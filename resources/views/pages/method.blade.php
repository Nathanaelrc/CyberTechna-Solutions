@extends('layouts.site')

@section('title', __('Método').' | CyberTechna Solutions')
@section('meta_description', __('Conoce el método de trabajo de CyberTechna Solutions para auditorías, pentesting, priorización y transferencia técnica.'))

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Método') }}</span>
                    <h1 class="hero-title">{{ __('Trabajamos para que la seguridad se entienda, se priorice y se ejecute.') }}</h1>
                    <p class="hero-copy mb-0">{{ __('Nuestro método combina lectura ejecutiva, evidencia técnica y acompañamiento operativo. La idea no es entregar un PDF bonito, sino ayudarte a tomar decisiones y darle tracción a la remediación.') }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="soft-label mb-3">{{ __('Principio rector') }}</div>
                        <h2 class="h3 text-white mb-3">{{ __('Cada hallazgo debe responder una pregunta de negocio.') }}</h2>
                        <p class="card-copy mb-0">{{ __('Qué riesgo representa, qué tan explotable es, qué afecta, qué prioridad merece y qué necesita el equipo para corregirlo.') }}</p>
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
                    <h2 class="section-heading">{{ __('Fases del trabajo') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('Ajustamos profundidad y alcance según el contexto, pero mantenemos una secuencia consistente para que el resultado sea útil y comparable.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($methodSteps as $step)
                    <div class="col-lg-6">
                        <div class="frame-card h-100">
                            <div class="soft-label mb-2">{{ __('Fase') }} {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $step['title'] }}</h3>
                            <p class="card-copy">{{ $step['summary'] }}</p>
                            <ul class="mb-0 mt-4">
                                @foreach ($step['outputs'] as $output)
                                    <li>{{ $output }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">{{ __('Cómo colaboramos') }}</div>
                        <h2 class="h3 text-white mb-3">{{ __('Principios de trabajo') }}</h2>
                        <ul class="mb-0 ps-3">
                            @foreach ($methodPrinciples as $principle)
                                <li class="mb-3">{{ $principle }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">{{ __('Entregables') }}</div>
                        <h2 class="h3 text-white mb-3">{{ __('Lo que recibe tu equipo') }}</h2>
                        <ul class="mb-0 ps-3">
                            @foreach ($methodArtifacts as $artifact)
                                <li class="mb-3">{{ $artifact }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="owner-banner">
                <div>
                    <div class="soft-label mb-2">{{ __('Siguiente paso') }}</div>
                    <strong class="d-block text-white mb-2">{{ __('Si quieres aplicar este método a tu entorno, definimos alcance y arrancamos con visibilidad real.') }}</strong>
                    <span class="form-note">{{ __('El detalle del tipo de auditoría o prueba se adapta a la necesidad del activo y del equipo.') }}</span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('services') }}" class="btn btn-ghost">{{ __('Ver servicios') }}</a>
                    <a href="{{ route('contact') }}" class="btn btn-signal">{{ __('Hablar con nosotros') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection