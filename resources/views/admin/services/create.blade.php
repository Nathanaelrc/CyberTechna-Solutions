@extends('layouts.admin')

@section('title', 'Nuevo servicio | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Nuevo contenido</div>
            <h1 class="display-6 text-white mb-2">Crear servicio</h1>
            <p class="muted mb-0">Define la pagina individual, los entregables y el orden del servicio dentro del sitio.</p>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf
            @include('admin.services.form')
        </form>
    </div>
@endsection