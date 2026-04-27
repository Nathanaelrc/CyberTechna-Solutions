@extends('layouts.site')

@section('title', __('Cursos').' | CyberTechna Solutions')
@section('meta_description', __('Cursos de Introducción a la Ciberseguridad, Fundamentos de Seguridad de la Información, Ethical Hacking y más.'))

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Cursos') }}</span>
                    <h1 class="hero-title">{{ __('Formación en ciberseguridad para usuarios, líderes y equipos técnicos.') }}</h1>
                    <p class="hero-copy mb-0">{{ __('Diseñamos cursos según el nivel del participante y la necesidad del equipo. Podemos empezar desde Introducción a la Ciberseguridad y Fundamentos de Seguridad de la Información, o profundizar con Ethical Hacking, secure coding y respuesta a incidentes.') }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="soft-label mb-3">{{ __('Enfoque') }}</div>
                        <h2 class="h3 text-white mb-3">{{ __('No es teoría aislada: buscamos cambio de criterio.') }}</h2>
                        <p class="card-copy mb-0">{{ __('Cada curso mezcla conceptos, ejemplos, ejercicios y lenguaje adaptado al rol para que el aprendizaje se convierta en mejores decisiones operativas.') }}</p>
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
                    <h2 class="section-heading">{{ __('Catálogo de cursos') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('Estos programas pueden impartirse como ruta completa o como módulos independientes, según el nivel y el objetivo del cliente.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($courses as $course)
                    <div class="col-lg-6">
                        <div class="service-card h-100">
                            <div class="soft-label mb-2">{{ __('Curso') }} {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $course->title }}</h3>
                            <p class="card-copy mb-3">{{ $course->description }}</p>
                            <div class="form-note mb-3">{{ $course->duration }} | {{ $course->audience }}</div>
                            <ul class="mb-0">
                                @foreach ($course->topics ?? [] as $topic)
                                    <li>{{ $topic }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-4">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-ghost">{{ __('Abrir curso') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                @foreach ($courseFormats as $format)
                    <div class="col-md-4">
                        <div class="frame-card h-100">
                            <div class="soft-label mb-2">{{ __('Formato') }} {{ $loop->iteration }}</div>
                            <h3 class="h5 text-white mb-3">{{ $format['title'] }}</h3>
                            <p class="card-copy mb-0">{{ $format['summary'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="owner-banner">
                <div>
                    <div class="soft-label mb-2">{{ __('Capacitación a medida') }}</div>
                    <strong class="d-block text-white mb-2">{{ __('Podemos adaptar el temario al nivel técnico, al área y al objetivo del cliente.') }}</strong>
                    <span class="form-note">{{ __('Esto incluye sensibilización general, perfiles ejecutivos, blue team, desarrollo seguro y prácticas ofensivas controladas.') }}</span>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-signal">{{ __('Solicitar plan formativo') }}</a>
            </div>
        </div>
    </section>
@endsection