<div class="row g-4">
    <div class="col-12">
        <label for="title" class="form-label">Titulo</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" maxlength="160" required>
    </div>

    <div class="col-12">
        <label for="excerpt" class="form-label">Resumen corto</label>
        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" maxlength="320" required>{{ old('excerpt', $post->excerpt) }}</textarea>
    </div>

    <div class="col-12">
        <label for="content" class="form-label">Contenido</label>
        <textarea class="form-control" id="content" name="content" rows="14" required>{{ old('content', $post->content) }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status" required>
            <option value="draft" @selected(old('status', $post->status) === 'draft')>draft</option>
            <option value="published" @selected(old('status', $post->status) === 'published')>published</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="published_at" class="form-label">Fecha de publicacion</label>
        <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">Los borradores solo se ven desde tu sesion de propietario. Las publicaciones se muestran en la landing e insights.</span>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        <button type="submit" class="btn btn-admin">Guardar publicacion</button>
    </div>
</div>