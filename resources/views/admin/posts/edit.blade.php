@extends('layouts.admin')

@section('title', __('Editar publicación').' | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">{{ __('Edición') }}</div>
            <h1 class="display-6 text-white mb-2">{{ __('Editar publicación') }}</h1>
            <p class="muted mb-0">{{ __('Ajusta el contenido y el estado de visibilidad de la publicación.') }}</p>
        </div>
        @if ($post->status === 'published')
            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">{{ __('Ver publicada') }}</a>
        @endif
    </div>

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}">
            @csrf
            @method('PUT')
            @include('admin.posts.form')
        </form>
    </div>
@endsection