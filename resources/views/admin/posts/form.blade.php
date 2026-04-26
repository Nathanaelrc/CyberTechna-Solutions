@php
    $translations = $post->translations ?? [];

    $titleEs = old('title_es', data_get($translations, 'es.title', $post->getRawOriginal('title')));
    $titleEn = old('title_en', data_get($translations, 'en.title', ''));
    $excerptEs = old('excerpt_es', data_get($translations, 'es.excerpt', $post->getRawOriginal('excerpt')));
    $excerptEn = old('excerpt_en', data_get($translations, 'en.excerpt', ''));
    $contentEs = old('content_es', data_get($translations, 'es.content', $post->getRawOriginal('content')));
    $contentEn = old('content_en', data_get($translations, 'en.content', ''));
@endphp

<div class="row g-4">
    <div class="col-12 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">ES / EN</div>
            <h2 class="h4 text-white mb-0">{{ __('Publicacion bilingue') }}</h2>
        </div>
        <span class="badge text-bg-secondary rounded-pill px-3 py-2">{{ __('Base: ES, apoyo: EN') }}</span>
    </div>

    <div class="col-lg-6">
        <div class="admin-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 text-white mb-0">{{ __('Español') }}</h3>
                <span class="badge text-bg-success rounded-pill">ES</span>
            </div>

            <div class="d-grid gap-3">
                <div>
                    <label for="title_es" class="form-label">{{ __('Titulo') }}</label>
                    <input type="text" class="form-control" id="title_es" name="title_es" value="{{ $titleEs }}" maxlength="160" required>
                </div>

                <div>
                    <label for="excerpt_es" class="form-label">{{ __('Resumen corto') }}</label>
                    <textarea class="form-control" id="excerpt_es" name="excerpt_es" rows="3" maxlength="320" required>{{ $excerptEs }}</textarea>
                </div>

                <div>
                    <label for="content_es" class="form-label">{{ __('Contenido') }}</label>
                    <textarea class="form-control" id="content_es" name="content_es" rows="14" required>{{ $contentEs }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 text-white mb-0">{{ __('English') }}</h3>
                <span class="badge text-bg-warning rounded-pill">EN</span>
            </div>

            <div class="d-grid gap-3">
                <div>
                    <label for="title_en" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title_en" name="title_en" value="{{ $titleEn }}" maxlength="160" required>
                </div>

                <div>
                    <label for="excerpt_en" class="form-label">Short summary</label>
                    <textarea class="form-control" id="excerpt_en" name="excerpt_en" rows="3" maxlength="320" required>{{ $excerptEn }}</textarea>
                </div>

                <div>
                    <label for="content_en" class="form-label">Content</label>
                    <textarea class="form-control" id="content_en" name="content_en" rows="14" required>{{ $contentEn }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">{{ __('Estado') }}</label>
        <select class="form-select" id="status" name="status" required>
            <option value="draft" @selected(old('status', $post->status) === 'draft')>{{ __('Borrador') }}</option>
            <option value="published" @selected(old('status', $post->status) === 'published')>{{ __('Publicado') }}</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="published_at" class="form-label">{{ __('Fecha de publicacion') }}</label>
        <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">{{ __('Los borradores solo se ven desde tu sesion de propietario. Las publicaciones se muestran en la landing e insights.') }}</span>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-light rounded-pill px-4">{{ __('Cancelar') }}</a>
        <button type="submit" class="btn btn-admin">{{ __('Guardar publicacion') }}</button>
    </div>
</div>