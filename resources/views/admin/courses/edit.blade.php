@extends('layouts.admin')

@section('title', 'Editar curso | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Edicion</div>
            <h1 class="display-6 text-white mb-2">Editar curso</h1>
            <p class="muted mb-0">Ajusta el temario, la audiencia, la duracion y la pagina individual del curso.</p>
        </div>
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}">
            @csrf
            @method('PUT')
            @include('admin.courses.form')
        </form>
    </div>
@endsection