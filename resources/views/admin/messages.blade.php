@extends('layouts.admin')

@section('title', 'Mensajes | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">Bandeja comercial</div>
            <h1 class="display-6 text-white mb-2">Mensajes recibidos</h1>
            <p class="muted mb-0">Cada solicitud enviada desde la landing aparece aqui para que puedas hacer seguimiento.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">Volver al dashboard</a>
    </div>

    <div class="d-grid gap-4">
        @forelse ($messages as $message)
            <article class="admin-card">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-3">
                    <div>
                        <h2 class="h4 text-white mb-1">{{ $message->name }}</h2>
                        <div class="muted">{{ $message->email }} @if ($message->company)| {{ $message->company }}@endif</div>
                    </div>
                    <div class="text-lg-end">
                        <div class="badge text-bg-{{ $message->reviewed_at ? 'success' : 'warning' }} mb-2">{{ $message->reviewed_at ? 'Revisado' : 'Pendiente' }}</div>
                        <div class="muted small">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="soft-label">Servicio</span>
                    <div class="text-white mt-1">{{ $message->service }}</div>
                </div>

                <p class="muted mb-4">{{ $message->message }}</p>

                @if (! $message->reviewed_at)
                    <form method="POST" action="{{ route('admin.messages.review', $message) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-admin">Marcar como revisado</button>
                    </form>
                @endif
            </article>
        @empty
            <div class="admin-card muted">No hay mensajes registrados todavia.</div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $messages->links('pagination::bootstrap-5') }}
    </div>
@endsection