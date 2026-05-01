@extends('layouts.admin')

@section('title', 'Editar usuario | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Accesos</div>
            <h1 class="display-6 text-white mb-2">Editar usuario</h1>
            <p class="muted mb-0">Actualiza datos, contraseña o rol de acceso para esta cuenta.</p>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            @include('admin.users.form')
        </form>
    </div>

    @if($user->is(auth()->user()))
    <div class="admin-card mt-4 px-4 px-md-5 py-4 py-md-5">
        <div class="mb-2">
            <h2 class="h4 text-white mb-2">Cambiar mi contraseña</h2>
            <p class="admin-form-note">Usa una contraseña robusta de al menos 8 caracteres y evita reutilizar claves de otros servicios.</p>
        </div>

        <hr class="admin-form-divider">

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-12">
                    <label for="current_password" class="form-label mb-2">Contraseña actual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label mb-2">Nueva contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label mb-2">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 pt-1">
                <button type="submit" class="btn btn-admin px-4">Actualizar contraseña</button>
            </div>
        </form>
    </div>
    @endif
@endsection