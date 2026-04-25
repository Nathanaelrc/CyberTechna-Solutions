@extends('layouts.admin')

@section('title', 'Editar servicio | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Edicion</div>
            <h1 class="display-6 text-white mb-2">Editar servicio</h1>
            <p class="muted mb-0">Ajusta su pagina individual, entregables y posicion dentro del sitio.</p>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')
            @include('admin.services.form')
        </form>
    </div>
@endsection