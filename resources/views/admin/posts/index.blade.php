@extends('layouts.admin')

@section('title', __('Publicaciones').' | CyberTechna Solutions')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">{{ __('Contenido') }}</div>
            <h1 class="display-6 text-white mb-2">{{ __('Publicaciones del sitio') }}</h1>
            <p class="muted mb-0">{{ __('Administra los insights visibles al publico y los borradores internos.') }}</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-admin">{{ __('Crear publicacion') }}</a>
    </div>

    <div class="table-shell">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Titulo') }}</th>
                        <th>{{ __('Estado') }}</th>
                        <th>{{ __('Autor') }}</th>
                        <th>{{ __('Fecha') }}</th>
                        <th class="text-end">{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                <div class="fw-semibold text-white">{{ $post->title }}</div>
                                <div class="muted small">/{{ $post->slug }}</div>
                            </td>
                            <td><span class="badge text-bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">{{ $post->status === 'published' ? __('Publicado') : __('Borrador') }}</span></td>
                            <td>{{ $post->author?->name ?? __('Sin autor') }}</td>
                            <td>{{ optional($post->published_at ?? $post->updated_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">{{ __('Editar') }}</a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('{{ __('Se eliminara esta publicacion. Continuar?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">{{ __('Eliminar') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="muted">{{ __('Todavia no has creado publicaciones.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
@endsection