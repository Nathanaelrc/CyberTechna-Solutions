@extends('layouts.admin')

@section('title', 'Dashboard | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Resumen operativo</div>
            <h1 class="display-6 text-white mb-2">Panel del propietario</h1>
            <p class="muted mb-0">Controla servicios, cursos, publicaciones y contactos desde un unico lugar.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.services.create') }}" class="btn btn-admin">Nuevo servicio</a>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-signal-soft">Nuevo curso</a>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-admin">Nueva publicacion</a>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-light rounded-pill px-4">Ver mensajes</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Publicadas</span>
                <strong>{{ $stats['published'] }}</strong>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Borradores</span>
                <strong>{{ $stats['drafts'] }}</strong>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Servicios</span>
                <strong>{{ $stats['services'] }}</strong>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Cursos</span>
                <strong>{{ $stats['courses'] }}</strong>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Mensajes sin revisar</span>
                <strong>{{ $stats['unreviewedMessages'] }}</strong>
            </div>
        </div>
        <div class="col-md-6 col-xl-2">
            <div class="admin-stat">
                <span class="muted">Mensajes totales</span>
                <strong>{{ $stats['totalMessages'] }}</strong>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="table-shell h-100">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <h2 class="h4 text-white mb-0">Publicaciones recientes</h2>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Gestionar</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Estado</th>
                                <th>Actualizado</th>
                                <th class="text-end">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPosts as $post)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-white">{{ $post->title }}</div>
                                        <div class="muted small">{{ $post->excerpt }}</div>
                                    </td>
                                    <td><span class="badge text-bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">{{ $post->status }}</span></td>
                                    <td>{{ optional($post->updated_at)->format('d/m/Y H:i') }}</td>
                                    <td class="text-end"><a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Editar</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="muted">Todavia no hay publicaciones creadas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <h2 class="h4 text-white mb-0">Servicios</h2>
                            <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Gestionar</a>
                        </div>

                        <div class="d-grid gap-3">
                            @forelse ($recentServices as $service)
                                <div class="frame-card p-3">
                                    <div class="fw-semibold text-white">{{ $service->title }}</div>
                                    <div class="muted small mb-2">/{{ $service->slug }}</div>
                                    <div class="muted">{{ $service->excerpt }}</div>
                                </div>
                            @empty
                                <div class="muted">Aun no hay servicios creados.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <h2 class="h4 text-white mb-0">Cursos</h2>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Gestionar</a>
                        </div>

                        <div class="d-grid gap-3">
                            @forelse ($recentCourses as $course)
                                <div class="frame-card p-3">
                                    <div class="fw-semibold text-white">{{ $course->title }}</div>
                                    <div class="muted small mb-2">/{{ $course->slug }}</div>
                                    <div class="muted">{{ $course->duration }} | {{ $course->audience }}</div>
                                </div>
                            @empty
                                <div class="muted">Aun no hay cursos creados.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                    <h2 class="h4 text-white mb-0">Ultimos mensajes</h2>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Abrir bandeja</a>
                </div>

                <div class="d-grid gap-3">
                    @forelse ($latestMessages as $message)
                        <div class="frame-card p-3">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <strong class="text-white">{{ $message->name }}</strong>
                                <span class="badge text-bg-{{ $message->reviewed_at ? 'success' : 'warning' }}">{{ $message->reviewed_at ? 'Revisado' : 'Nuevo' }}</span>
                            </div>
                            <div class="muted small mb-2">{{ $message->email }} | {{ $message->service }}</div>
                            <p class="muted mb-0">{{ \Illuminate\Support\Str::limit($message->message, 120) }}</p>
                        </div>
                    @empty
                        <div class="muted">Aun no has recibido mensajes desde el formulario.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection