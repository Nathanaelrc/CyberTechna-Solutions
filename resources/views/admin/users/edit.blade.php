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
@endsection