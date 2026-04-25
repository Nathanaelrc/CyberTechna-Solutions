<div class="row g-4">
    <div class="col-12">
        <label for="title" class="form-label">Titulo</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" maxlength="160" required>
    </div>

    <div class="col-12">
        <label for="excerpt" class="form-label">Resumen corto</label>
        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" maxlength="320" required>{{ old('excerpt', $service->excerpt) }}</textarea>
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Descripcion</label>
        <textarea class="form-control" id="description" name="description" rows="8" required>{{ old('description', $service->description) }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="deliverables" class="form-label">Entregables</label>
        <textarea class="form-control" id="deliverables" name="deliverables" rows="8" placeholder="Un entregable por linea">{{ old('deliverables', implode("\n", $service->deliverables ?? [])) }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="details" class="form-label">Detalles o variantes</label>
        <textarea class="form-control" id="details" name="details" rows="8" placeholder="Un detalle por linea">{{ old('details', implode("\n", $service->details ?? [])) }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status" required>
            <option value="draft" @selected(old('status', $service->status) === 'draft')>draft</option>
            <option value="published" @selected(old('status', $service->status) === 'published')>published</option>
        </select>
    </div>

    <div class="col-md-6">
        <label for="sort_order" class="form-label">Orden</label>
        <input type="number" class="form-control" id="sort_order" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $service->sort_order ?? 0) }}" required>
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">Los servicios publicados aparecen en la home, en la pagina de servicios y en su propia pagina individual.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        @if ($service->exists)
            <a href="{{ route('services.show', $service) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">Vista previa</a>
        @endif
        <button type="submit" class="btn btn-admin">Guardar servicio</button>
    </div>
</div>