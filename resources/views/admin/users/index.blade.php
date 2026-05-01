@extends('layouts.admin')

@section('title', 'Usuarios | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Accesos</div>
            <h1 class="display-6 text-white mb-2">Usuarios del sistema</h1>
            <p class="muted mb-0">Crea cuentas nuevas, decide quién administra el sitio y quién solo accede al catálogo de cursos.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-admin">Crear usuario</a>
    </div>

    <div class="table-shell">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Creado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="fw-semibold text-white">{{ $user->name }}</div>
                                @if (auth()->id() === $user->id)
                                    <div class="muted small">Cuenta actual</div>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge text-bg-{{ $user->is_admin ? 'success' : 'secondary' }}">
                                    {{ $user->is_admin ? 'Admin' : 'Usuario' }}
                                </span>
                            </td>
                            <td>{{ optional($user->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Editar / contraseña</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Se eliminará este usuario. ¿Continuar?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted">Todavía no hay usuarios creados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
@endsection