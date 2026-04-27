@extends('layouts.site')

@section('title', __('CyberTechna Solutions').' | '. __('Ciberseguridad para empresas'))

@section('content')
    @php($auditService = $serviceHighlights->firstWhere('slug', 'auditorias-de-ciberseguridad'))

    <section class="section-space pb-4 pb-lg-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">{{ __('Ciberseguridad con foco en ejecución') }}</span>
                    <h1 class="hero-title">{{ __('Auditamos, explicamos el riesgo y ayudamos a corregirlo sin perder foco de negocio.') }}</h1>
                    <p class="hero-copy mb-4">{{ __('CyberTechna Solutions acompaña a empresas que necesitan entender su exposición real, priorizar remediaciones y fortalecer equipos a través de auditorías, pentesting y formación especializada.') }}</p>

                    <div class="hero-actions">
                        <a href="{{ route('contact') }}" class="btn btn-signal btn-lg">{{ __('Solicitar evaluación') }}</a>
                        <a href="{{ route('services') }}" class="btn btn-ghost btn-lg">{{ __('Explorar servicios') }}</a>
                    </div>

                    <div class="metrics-grid">
                        @foreach ($metrics as $metric)
                            <div class="metric-pill">
                                <strong>{{ $metric['value'] }}</strong>
                                <span>{{ $metric['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    @auth
                        @if (auth()->user()->is_admin)
                            <div class="owner-banner mt-4">
                                <div>
                                    <div class="soft-label mb-2">{{ __('Zona del propietario') }}</div>
                                    <strong class="d-block text-white mb-1">{{ __('Tu panel privado ya está integrado al sitio.') }}</strong>
                                    <span class="form-note">{{ __('Desde ahí podrás publicar insights, revisar mensajes y mantener visible solo lo que es para ti.') }}</span>
                                </div>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-owner">{{ __('Ir al panel') }}</a>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="soft-label mb-3">{{ __('Lo esencial') }}</div>
                        <h2 class="h3 text-white mb-4">{{ __('Una entrada simple para decidir por dónde empezar.') }}</h2>

                        <div class="hero-grid">
                            @foreach ($methodSteps as $step)
                                <div class="status-line">
                                    <span class="status-index">0{{ $loop->iteration }}</span>
                                    <div>
                                        <strong class="d-block text-white mb-1">{{ $step['title'] }}</strong>
                                        <span class="form-note">{{ $step['summary'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="frame-card mt-4 mb-0">
                            <div class="soft-label mb-2">{{ __('Siguiente paso') }}</div>
                            <p class="card-copy mb-3">{{ __('Si ya sabes que necesitas una auditoría, una prueba ofensiva o capacitación, entra a la sección correspondiente y revisa el detalle del servicio.') }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('services') }}" class="btn btn-ghost">{{ __('Servicios') }}</a>
                                <a href="{{ route('courses') }}" class="btn btn-ghost">{{ __('Cursos') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space pt-3">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">{{ __('Cuatro formas claras de trabajar con nosotros.') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('La home concentra lo relevante. El detalle técnico y comercial ahora vive en páginas dedicadas para que cada servicio pueda explicarse con más profundidad.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($serviceHighlights as $service)
                    <div class="col-md-6">
                        <article class="service-card">
                            <div class="soft-label mb-2">{{ __('Linea') }} {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $service->title }}</h3>
                            <p class="card-copy">{{ $service->excerpt }}</p>
                            <ul class="mb-0 mt-4">
                                @foreach ($service->deliverables ?? [] as $deliverable)
                                    <li>{{ $deliverable }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-4">
                                <a href="{{ route('services.show', $service) }}" class="btn btn-ghost">{{ __('Ver detalle') }}</a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">{{ __('Auditorías pensadas para explicar el riesgo, no solo enumerarlo.') }}</h2>
                    <p class="section-copy">{{ __('El servicio de auditoría puede aterrizarse sobre madurez, infraestructura, nube, aplicaciones o seguridad de la información. Estas son algunas coberturas habituales.') }}</p>
                    <a href="{{ route('services') }}" class="btn btn-signal mt-3">{{ __('Ver auditorías') }}</a>
                </div>

                <div class="col-lg-7">
                    <div class="row g-4">
                        @foreach (array_slice($auditService?->details ?? [], 0, 3) as $detail)
                            <div class="col-md-4">
                                <div class="frame-card h-100">
                                    <div class="soft-label mb-2">{{ __('Auditoría') }} {{ $loop->iteration }}</div>
                                    <h3 class="h5 text-white">{{ $detail }}</h3>
                                    <p class="card-copy mb-0">{{ __('En la página de detalle se explica alcance, entregables y cómo se traduce a un plan de acción priorizado.') }}</p>
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
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">{{ __('Cursos que van desde lo introductorio hasta lo ofensivo.') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('Abrimos una página exclusiva para cursos para explicar temarios, audiencias y profundidad. Estos son algunos de los programas base.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($coursesCatalog as $course)
                    <div class="col-md-4">
                        <div class="frame-card h-100">
                            <div class="soft-label mb-2">{{ __('Curso') }} {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $course->title }}</h3>
                            <p class="card-copy mb-2">{{ $course->excerpt }}</p>
                            <div class="form-note">{{ $course->duration }} | {{ $course->audience }}</div>
                            <div class="mt-4">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-ghost">{{ __('Ver curso') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('courses') }}" class="btn btn-ghost">{{ __('Explorar catálogo completo') }}</a>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">{{ __('Insights, alertas y comunicados.') }}</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">{{ __('Aquí compartimos hallazgos, alertas, aprendizajes y novedades de servicio para equipos que quieren mejorar su postura con criterio.') }}</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($latestPosts as $post)
                    <div class="col-md-4">
                        <article class="article-card">
                            <div class="soft-label mb-3">{{ optional($post->published_at)->format('d M Y') }}</div>
                            <h3 class="h4 mb-3"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                            <p class="card-copy mb-4">{{ $post->excerpt }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-ghost">{{ __('Leer insight') }}</a>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="frame-card">
                            <div class="soft-label mb-2">{{ __('Publicaciones en preparación') }}</div>
                            <p class="card-copy mb-3">{{ __('Estamos preparando insights para compartir alertas, aprendizajes y novedades relevantes sobre auditoría, pentesting y formación.') }}</p>
                            <a href="{{ route('contact') }}" class="btn btn-signal">{{ __('Ir a contacto') }}</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="frame-card h-100">
                        <div class="signal-bar"></div>
                        <h2 class="section-heading mb-3">{{ __('Seguridad con criterio, no solo con checklists.') }}</h2>
                        <p class="section-copy mb-0">{{ __('Cada servicio combina evidencia técnica, priorización y acompañamiento para traducir la seguridad en decisiones claras, mejoras ejecutables y confianza para clientes y equipos.') }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="owner-banner h-100">
                        <div>
                            <div class="soft-label mb-2">{{ __('Contacto directo') }}</div>
                            <strong class="d-block text-white mb-2">{{ __('Cuéntanos tu necesidad y te proponemos un alcance.') }}</strong>
                            <span class="form-note">{{ __('Desde auditorías hasta formación interna, la ruta más directa ahora vive en la página de contacto.') }}</span>
                        </div>
                        <a href="{{ route('contact') }}" class="btn btn-signal">{{ __('Ir a contacto') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection