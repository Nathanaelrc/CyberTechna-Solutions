@extends('layouts.site')

@section('title', 'Mi catálogo de cursos | CyberTechna Solutions')

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="soft-label mb-3">Catálogo autenticado</div>
                    <h1 class="hero-title display-5 mb-3">Tus cursos y accesos de clase en un solo lugar.</h1>
                    <p class="section-copy mb-0">Desde aquí puedes revisar el catálogo publicado de CyberTechna, entrar al detalle de cada curso y abrir el enlace de clase cuando ya esté disponible.</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-2">Acceso actual</div>
                        <strong class="d-block text-white mb-2">{{ auth()->user()->name }}</strong>
                        <p class="form-note mb-0">{{ auth()->user()->is_admin ? 'Rol admin' : 'Usuario de catálogo' }} | {{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row g-4">
                @forelse ($courses as $course)
                    @php($nextSession = $course->nextSessionLocal())
                    <div class="col-lg-6">
                        <div class="service-card h-100">
                            <div class="soft-label mb-2">Curso</div>
                            <h2 class="h4 text-white mb-3">{{ $course->title }}</h2>
                            <p class="card-copy mb-3">{{ $course->excerpt }}</p>
                            <div class="form-note mb-2">{{ $course->deliveryModeLabel() }}@if ($course->meetingProviderLabel()) | {{ $course->meetingProviderLabel() }}@endif</div>
                            @if ($nextSession)
                                <div class="form-note mb-3">Próxima edición: {{ $nextSession->format('d/m/Y H:i') }} {{ $course->session_timezone }}</div>
                            @endif
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="{{ route('portal.courses.show', $course) }}" class="btn btn-owner">Abrir curso</a>
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-ghost">Ver ficha pública</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="frame-card">
                            <strong class="d-block text-white mb-2">Aún no hay cursos publicados.</strong>
                            <span class="form-note">Cuando el equipo publique nuevas formaciones aparecerán aquí.</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection