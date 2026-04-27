@php
    $translations = $service->translations ?? [];
    $rawDeliverables = $service->getRawOriginal('deliverables');
    $rawDetails = $service->getRawOriginal('details');
    $deliverablesFallback = is_array($rawDeliverables) ? $rawDeliverables : (is_string($rawDeliverables) ? (json_decode($rawDeliverables, true) ?: []) : []);
    $detailsFallback = is_array($rawDetails) ? $rawDetails : (is_string($rawDetails) ? (json_decode($rawDetails, true) ?: []) : []);

    $titleEs = old('title_es', data_get($translations, 'es.title', $service->getRawOriginal('title')));
    $titleEn = old('title_en', data_get($translations, 'en.title', ''));
    $excerptEs = old('excerpt_es', data_get($translations, 'es.excerpt', $service->getRawOriginal('excerpt')));
    $excerptEn = old('excerpt_en', data_get($translations, 'en.excerpt', ''));
    $descriptionEs = old('description_es', data_get($translations, 'es.description', $service->getRawOriginal('description')));
    $descriptionEn = old('description_en', data_get($translations, 'en.description', ''));
    $deliverablesEs = old('deliverables_es', implode("\n", data_get($translations, 'es.deliverables', $deliverablesFallback)));
    $deliverablesEn = old('deliverables_en', implode("\n", data_get($translations, 'en.deliverables', [])));
    $detailsEs = old('details_es', implode("\n", data_get($translations, 'es.details', $detailsFallback)));
    $detailsEn = old('details_en', implode("\n", data_get($translations, 'en.details', [])));
@endphp

<div class="row g-4">
    <div class="col-12 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">ES / EN</div>
            <h2 class="h4 text-white mb-0">Servicio bilingüe</h2>
        </div>
        <span class="badge text-bg-secondary rounded-pill px-3 py-2">Base: ES, apoyo: EN</span>
    </div>

    <div class="col-lg-6">
        <div class="admin-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 text-white mb-0">Español</h3>
                <span class="badge text-bg-success rounded-pill">ES</span>
            </div>

            <div class="d-grid gap-3">
                <div>
                    <label for="title_es" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title_es" name="title_es" value="{{ $titleEs }}" maxlength="160" required>
                </div>

                <div>
                    <label for="excerpt_es" class="form-label">Resumen corto</label>
                    <textarea class="form-control" id="excerpt_es" name="excerpt_es" rows="3" maxlength="320" required>{{ $excerptEs }}</textarea>
                </div>

                <div>
                    <label for="description_es" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description_es" name="description_es" rows="8" required>{{ $descriptionEs }}</textarea>
                </div>

                <div>
                    <label for="deliverables_es" class="form-label">Entregables</label>
                    <textarea class="form-control" id="deliverables_es" name="deliverables_es" rows="8" placeholder="Un entregable por línea" required>{{ $deliverablesEs }}</textarea>
                </div>

                <div>
                    <label for="details_es" class="form-label">Detalles o variantes</label>
                    <textarea class="form-control" id="details_es" name="details_es" rows="8" placeholder="Un detalle por línea" required>{{ $detailsEs }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="admin-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 text-white mb-0">English</h3>
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
                    <label for="description_en" class="form-label">Description</label>
                    <textarea class="form-control" id="description_en" name="description_en" rows="8" required>{{ $descriptionEn }}</textarea>
                </div>

                <div>
                    <label for="deliverables_en" class="form-label">Deliverables</label>
                    <textarea class="form-control" id="deliverables_en" name="deliverables_en" rows="8" placeholder="One deliverable per line" required>{{ $deliverablesEn }}</textarea>
                </div>

                <div>
                    <label for="details_en" class="form-label">Details or variants</label>
                    <textarea class="form-control" id="details_en" name="details_en" rows="8" placeholder="One detail per line" required>{{ $detailsEn }}</textarea>
                </div>
            </div>
        </div>
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
    <span class="muted">Los servicios publicados aparecen en la home, en la página de servicios y en su propia página individual.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        @if ($service->exists)
            <a href="{{ route('services.show', $service) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">Vista previa</a>
        @endif
        <button type="submit" class="btn btn-admin">Guardar servicio</button>
    </div>
</div>