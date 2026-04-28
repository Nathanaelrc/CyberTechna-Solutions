@extends('layouts.site')

@section('title', $course->title.' | Mi catálogo')
@section('meta_description', $course->excerpt)

@section('content')
    @php($nextSession = $course->nextSessionLocal())
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="soft-label mb-3">Mi catálogo</div>
                    <h1 class="hero-title display-5 mb-3">{{ $course->title }}</h1>
                    <p class="section-copy mb-4">{{ $course->description }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        @if ($joinUrl)
                            <a href="{{ $joinUrl }}" class="btn btn-signal" target="_blank" rel="noreferrer">Entrar a la clase</a>
                        @endif
                        @if ($course->registration_url)
                            <a href="{{ $course->registration_url }}" class="btn btn-ghost" target="_blank" rel="noreferrer">Ver registro o reserva</a>
                        @endif
                        <a href="{{ route('portal.courses.index') }}" class="btn btn-ghost">Volver al catálogo</a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-2">Sesión</div>
                        <strong class="d-block text-white mb-2">{{ $nextSession ? $nextSession->format('d/m/Y H:i') : 'Por coordinar' }}</strong>
                        <p class="form-note mb-3">{{ $course->deliveryModeLabel() }}@if ($course->meetingProviderLabel()) | {{ $course->meetingProviderLabel() }}@endif</p>
                        <div class="form-note mb-2">Duración: {{ $course->duration }}</div>
                        <div class="form-note">Audiencia: {{ $course->audience }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="frame-card">
                <div class="soft-label mb-3">Temario</div>
                <ul class="mb-0 ps-3">
                    @foreach ($course->topics ?? [] as $topic)
                        <li class="mb-3">{{ $topic }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection