@extends('layouts.site')

@section('title', $course->title.' | CyberTechna Solutions')
@section('meta_description', $course->excerpt)

@section('content')
    @php($nextSession = $course->nextSessionLocal())
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Curso') }}</span>
                    <h1 class="hero-title">{{ $course->title }}</h1>
                    <p class="hero-copy mb-3">{{ $course->excerpt }}</p>
                    <div class="form-note mb-4">{{ $course->duration }} | {{ $course->audience }}</div>
                    <p class="section-copy mb-0">{{ $course->description }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        @if ($nextSession)
                            <div class="soft-label mb-2">{{ __('Próxima edición') }}</div>
                            <strong class="d-block text-white mb-2">{{ $nextSession->format('d/m/Y H:i') }} {{ $course->session_timezone }}</strong>
                            <p class="form-note mb-4">{{ $course->deliveryModeLabel() }}@if ($course->meetingProviderLabel()) | {{ $course->meetingProviderLabel() }}@endif</p>
                        @endif

                        <div class="soft-label mb-3">{{ __('Temas principales') }}</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($course->topics ?? [] as $topic)
                                <li class="mb-3">{{ $topic }}</li>
                            @endforeach
                        </ul>

                        @if ($course->registration_url)
                            <div class="mt-4">
                                <a href="{{ $course->registration_url }}" class="btn btn-signal" target="_blank" rel="noreferrer">{{ __('Reservar cupo') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedCourses->isNotEmpty())
        <section class="section-space pt-0">
            <div class="container">
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-lg-7">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading">{{ __('Otros cursos del catálogo') }}</h2>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($relatedCourses as $related)
                        <div class="col-md-4">
                            <article class="service-card h-100">
                                <div class="soft-label mb-2">{{ __('Curso') }}</div>
                                <h3 class="h4 text-white mb-3">{{ $related->title }}</h3>
                                <p class="card-copy mb-3">{{ $related->excerpt }}</p>
                                <div class="form-note mb-3">{{ $related->duration }} | {{ $related->audience }}</div>
                                <div class="mt-4">
                                    <a href="{{ route('courses.show', $related) }}" class="btn btn-ghost">{{ __('Abrir curso') }}</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section-space pt-0">
        <div class="container">
            <div class="owner-banner">
                <div>
                    <div class="soft-label mb-2">{{ __('Capacitación a medida') }}</div>
                    <strong class="d-block text-white mb-2">{{ __('Este curso puede adaptarse al nivel técnico, al área, a la intensidad y a la modalidad que necesite tu equipo.') }}</strong>
                    <span class="form-note">{{ __('También podemos operarlo como cohorte remota, híbrida o presencial, e integrarlo dentro de una ruta mayor de formación en ciberseguridad.') }}</span>
                </div>
                <a href="{{ $course->registration_url ?: route('contact') }}" class="btn btn-signal" @if ($course->registration_url) target="_blank" rel="noreferrer" @endif>{{ $course->registration_url ? __('Reservar cupo') : __('Solicitar plan formativo') }}</a>
            </div>
        </div>
    </section>
@endsection