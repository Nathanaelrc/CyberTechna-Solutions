<div class="row g-4">
    <div class="col-md-6">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" maxlength="255" required>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" maxlength="255" required>
    </div>

    @if(!$user->exists || !$user->is(auth()->user()))
    <div class="col-md-6">
        <label for="password" class="form-label">{{ $user->exists ? 'Nueva contraseña' : 'Contraseña' }}</label>
        <input type="password" class="form-control" id="password" name="password" minlength="8" {{ $user->exists ? '' : 'required' }}>
        <div class="form-text">{{ $user->exists ? 'Déjalo vacío para conservar la contraseña actual.' : 'Usa al menos 8 caracteres.' }}</div>
    </div>
    @endif

    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_admin" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin))>
            <label class="form-check-label" for="is_admin">Cuenta administradora</label>
            <div class="form-text">Los admins pueden crear contenido, generar clases y administrar usuarios.</div>
        </div>
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">Las cuentas normales solo acceden al catálogo autenticado de cursos y a los enlaces de clase disponibles.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        <button type="submit" class="btn btn-admin">Guardar usuario</button>
    </div>
</div>