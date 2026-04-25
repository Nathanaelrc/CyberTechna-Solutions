<div class="row g-4">
    <div class="col-12">
        <label for="title" class="form-label">Titulo</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" maxlength="160" required>
    </div>

    <div class="col-12">
        <label for="excerpt" class="form-label">Resumen corto</label>
        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" maxlength="320" required>{{ old('excerpt', $course->excerpt) }}</textarea>
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Descripcion</label>
        <textarea class="form-control" id="description" name="description" rows="8" required>{{ old('description', $course->description) }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="audience" class="form-label">Audiencia</label>
        <input type="text" class="form-control" id="audience" name="audience" value="{{ old('audience', $course->audience) }}" maxlength="190" required>
    </div>

    <div class="col-md-6">
        <label for="duration" class="form-label">Duracion</label>
        <input type="text" class="form-control" id="duration" name="duration" value="{{ old('duration', $course->duration) }}" maxlength="120" required>
    </div>

    <div class="col-md-6">
        <label for="topics" class="form-label">Temas</label>
        <textarea class="form-control" id="topics" name="topics" rows="8" placeholder="Un tema por linea">{{ old('topics', implode("\n", $course->topics ?? [])) }}</textarea>
    </div>

    <div class="col-md-3">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status" required>
            <option value="draft" @selected(old('status', $course->status) === 'draft')>draft</option>
            <option value="published" @selected(old('status', $course->status) === 'published')>published</option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="sort_order" class="form-label">Orden</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $course->sort_order ?? 0) }}" required>
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">Los cursos publicados aparecen en la pagina de cursos y en su pagina individual.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        @if ($course->exists)
            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">Vista previa</a>
        @endif
        <button type="submit" class="btn btn-admin">Guardar curso</button>
    </div>
</div>