@extends('layouts.admin')

@section('title', 'Cursos | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Formación</div>
            <h1 class="display-6 text-white mb-2">Cursos del sitio</h1>
            <p class="muted mb-0">Administra el catálogo y las páginas individuales de cada curso.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-admin">Crear curso</a>
    </div>

    <div class="table-shell">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Orden</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>
                                <div class="fw-semibold text-white">{{ $course->title }}</div>
                                <div class="muted small">/{{ $course->slug }}</div>
                            </td>
                            <td><span class="badge text-bg-{{ $course->status === 'published' ? 'success' : 'secondary' }}">{{ $course->status }}</span></td>
                            <td>{{ $course->sort_order }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-light rounded-pill px-3" target="_blank" rel="noreferrer">Ver</a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Editar</a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Se eliminará este curso. ¿Continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="muted">Todavía no has creado cursos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
@endsection