@extends('layouts.site')

@section('title', $service->title.' | CyberTechna Solutions')
@section('meta_description', $service->excerpt)

@section('content')
    <section class="section-space pb-4">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">Servicio</span>
                    <h1 class="hero-title">{{ $service->title }}</h1>
                    <p class="hero-copy mb-4">{{ $service->excerpt }}</p>
                    <p class="section-copy mb-0">{{ $service->description }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card h-100">
                        <div class="soft-label mb-3">Entregables frecuentes</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($service->deliverables ?? [] as $deliverable)
                                <li class="mb-3">{{ $deliverable }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (! empty($service->details))
        <section class="section-space pt-0">
            <div class="container">
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-lg-7">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading">Como se aterriza este servicio</h2>
                    </div>
                    <div class="col-lg-5">
                        <p class="section-copy mb-0">La profundidad depende del alcance y del tipo de activo, pero estas son algunas lineas habituales dentro del servicio.</p>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($service->details as $detail)
                        <div class="col-md-6 col-xl-3">
                            <div class="frame-card h-100">
                                <div class="soft-label mb-2">Detalle {{ $loop->iteration }}</div>
                                <h3 class="h5 text-white mb-0">{{ $detail }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($relatedServices->isNotEmpty())
        <section class="section-space pt-0">
            <div class="container">
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-lg-7">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading">Otros servicios relacionados</h2>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($relatedServices as $related)
                        <div class="col-md-4">
                            <article class="service-card h-100">
                                <div class="soft-label mb-2">Servicio</div>
                                <h3 class="h4 text-white mb-3">{{ $related->title }}</h3>
                                <p class="card-copy">{{ $related->excerpt }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('services.show', $related) }}" class="btn btn-ghost">Abrir servicio</a>
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
                    <div class="soft-label mb-2">Siguiente paso</div>
                    <strong class="d-block text-white mb-2">Si este servicio encaja con tu necesidad, definimos alcance y prioridades contigo.</strong>
                    <span class="form-note">Podemos partir por una reunion breve y bajar el servicio a tu contexto tecnico y de negocio.</span>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-signal">Solicitar propuesta</a>
            </div>
        </div>
    </section>
@endsection