@extends('layouts.admin')

@section('title', 'Servicios | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Contenido comercial</div>
            <h1 class="display-6 text-white mb-2">Servicios del sitio</h1>
            <p class="muted mb-0">Administra las paginas individuales de servicios y su orden dentro del sitio.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn btn-admin">Crear servicio</a>
    </div>

    <div class="table-shell">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Estado</th>
                        <th>Orden</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>
                                <div class="fw-semibold text-white">{{ $service->title }}</div>
                                <div class="muted small">/{{ $service->slug }}</div>
                            </td>
                            <td><span class="badge text-bg-{{ $service->status === 'published' ? 'success' : 'secondary' }}">{{ $service->status }}</span></td>
                            <td>{{ $service->sort_order }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-light rounded-pill px-3" target="_blank" rel="noreferrer">Ver</a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Editar</a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Se eliminara este servicio. Continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="muted">Todavia no has creado servicios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
@endsection