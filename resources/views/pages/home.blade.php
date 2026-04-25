@extends('layouts.site')

@section('title', 'CyberTechna Solutions | Ciberseguridad para empresas')

@section('content')
    @php($auditService = $serviceHighlights->firstWhere('slug', 'auditorias-de-ciberseguridad'))

    <section class="section-space pb-4 pb-lg-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">Ciberseguridad con foco en ejecucion</span>
                    <h1 class="hero-title">Auditamos, explicamos el riesgo y ayudamos a corregirlo sin perder foco de negocio.</h1>
                    <p class="hero-copy mb-4">CyberTechna Solutions acompana a empresas que necesitan entender su exposicion real, priorizar remediaciones y fortalecer equipos a traves de auditorias, pentesting y formacion especializada.</p>

                    <div class="hero-actions">
                        <a href="{{ route('contact') }}" class="btn btn-signal btn-lg">Solicitar evaluacion</a>
                        <a href="{{ route('services') }}" class="btn btn-ghost btn-lg">Explorar servicios</a>
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
                                    <div class="soft-label mb-2">Zona del propietario</div>
                                    <strong class="d-block text-white mb-1">Tu panel privado ya esta integrado al sitio.</strong>
                                    <span class="form-note">Desde ahi podras publicar insights, revisar mensajes y mantener visible solo lo que es para ti.</span>
                                </div>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-owner">Ir al panel</a>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="soft-label mb-3">Lo esencial</div>
                        <h2 class="h3 text-white mb-4">Una entrada simple para decidir por donde empezar.</h2>

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
                            <div class="soft-label mb-2">Siguiente paso</div>
                            <p class="card-copy mb-3">Si ya sabes que necesitas una auditoria, una prueba ofensiva o capacitacion, entra a la seccion correspondiente y revisa el detalle del servicio.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('services') }}" class="btn btn-ghost">Servicios</a>
                                <a href="{{ route('courses') }}" class="btn btn-ghost">Cursos</a>
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
                    <h2 class="section-heading">Cuatro formas claras de trabajar con nosotros.</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">La home concentra lo relevante. El detalle tecnico y comercial ahora vive en paginas dedicadas para que cada servicio pueda explicarse con mas profundidad.</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($serviceHighlights as $service)
                    <div class="col-md-6">
                        <article class="service-card">
                            <div class="soft-label mb-2">Linea {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $service->title }}</h3>
                            <p class="card-copy">{{ $service->excerpt }}</p>
                            <ul class="mb-0 mt-4">
                                @foreach ($service->deliverables ?? [] as $deliverable)
                                    <li>{{ $deliverable }}</li>
                                @endforeach
                            </ul>
                            <div class="mt-4">
                                <a href="{{ route('services.show', $service) }}" class="btn btn-ghost">Ver detalle</a>
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
                    <h2 class="section-heading">Auditorias pensadas para explicar el riesgo, no solo enumerarlo.</h2>
                    <p class="section-copy">El servicio de auditoria puede aterrizarse sobre madurez, infraestructura, nube, aplicaciones o seguridad de la informacion. Estas son algunas coberturas habituales.</p>
                    <a href="{{ route('services') }}" class="btn btn-signal mt-3">Ver auditorias</a>
                </div>

                <div class="col-lg-7">
                    <div class="row g-4">
                        @foreach (array_slice($auditService?->details ?? [], 0, 3) as $detail)
                            <div class="col-md-4">
                                <div class="frame-card h-100">
                                    <div class="soft-label mb-2">Auditoria {{ $loop->iteration }}</div>
                                    <h3 class="h5 text-white">{{ $detail }}</h3>
                                    <p class="card-copy mb-0">En la pagina de detalle se explica alcance, entregables y como se traduce a un plan de accion priorizado.</p>
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
                    <h2 class="section-heading">Cursos que van desde lo introductorio hasta lo ofensivo.</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">Abrimos una pagina exclusiva para cursos para explicar temarios, audiencias y profundidad. Estos son algunos de los programas base.</p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($coursesCatalog as $course)
                    <div class="col-md-4">
                        <div class="frame-card h-100">
                            <div class="soft-label mb-2">Curso {{ $loop->iteration }}</div>
                            <h3 class="h4 text-white mb-3">{{ $course->title }}</h3>
                            <p class="card-copy mb-2">{{ $course->excerpt }}</p>
                            <div class="form-note">{{ $course->duration }} | {{ $course->audience }}</div>
                            <div class="mt-4">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-ghost">Ver curso</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('courses') }}" class="btn btn-ghost">Explorar catalogo completo</a>
            </div>
        </div>
    </section>

    <section class="section-space pt-0">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <div class="signal-bar"></div>
                    <h2 class="section-heading">Insights y comunicados para tus clientes.</h2>
                </div>
                <div class="col-lg-5">
                    <p class="section-copy mb-0">Esta seccion se alimenta desde tu panel privado. Puedes publicar hallazgos, alertas, casos o anuncios comerciales.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($latestPosts as $post)
                    <div class="col-md-4">
                        <article class="article-card">
                            <div class="soft-label mb-3">{{ optional($post->published_at)->format('d M Y') }}</div>
                            <h3 class="h4 mb-3"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                            <p class="card-copy mb-4">{{ $post->excerpt }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-ghost">Leer insight</a>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="frame-card">
                            <div class="soft-label mb-2">Sin publicaciones aun</div>
                            <p class="card-copy mb-3">Cuando entres al panel privado podras crear tus primeros insights para mostrar novedades, aprendizajes o avisos de servicio.</p>
                            <a href="{{ route('login') }}" class="btn btn-owner">Entrar al panel</a>
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
                        <h2 class="section-heading mb-3">El detalle ahora esta donde corresponde.</h2>
                        <p class="section-copy mb-0">La home se queda con el mensaje principal y el acceso rapido. Si quieres revisar con calma las auditorias, el metodo, el catalogo de cursos o hablar de tu caso, ahora cada tema tiene su propia pagina.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="owner-banner h-100">
                        <div>
                            <div class="soft-label mb-2">Contacto directo</div>
                            <strong class="d-block text-white mb-2">Cuentanos tu necesidad y te proponemos un alcance.</strong>
                            <span class="form-note">Desde auditorias hasta formacion interna, la ruta mas directa ahora vive en la pagina de contacto.</span>
                        </div>
                        <a href="{{ route('contact') }}" class="btn btn-signal">Ir a contacto</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection