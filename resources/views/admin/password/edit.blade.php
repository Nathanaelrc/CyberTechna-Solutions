@extends('layouts.admin')

@section('title', 'Mi contraseña | CyberTechna Solutions')

@section('content')
    <div class="admin-form-shell mx-auto">
        <div class="d-flex flex-column gap-3 mb-5">
            <div class="text-uppercase muted small fw-bold">Seguridad</div>
            <div>
                <h1 class="display-6 text-white mb-2">Cambiar mi contraseña</h1>
                <p class="muted mb-0">Actualiza tu clave de acceso al panel administrador.</p>
            </div>
        </div>

        <div class="admin-card px-4 px-md-5 py-4 py-md-5">
            <div class="mb-2">
                <h2 class="h4 text-white mb-2">Datos de seguridad</h2>
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
    </div>
@endsection
