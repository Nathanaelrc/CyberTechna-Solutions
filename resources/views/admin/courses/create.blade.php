@extends('layouts.admin')

@section('title', 'Nuevo curso | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Nuevo contenido</div>
            <h1 class="display-6 text-white mb-2">Crear curso</h1>
            <p class="muted mb-0">Define el curso, su audiencia, duracion y pagina individual dentro del sitio.</p>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            @include('admin.courses.form')
        </form>
    </div>
@endsection