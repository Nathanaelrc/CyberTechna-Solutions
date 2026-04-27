@php
    $translations = $course->translations ?? [];
    $rawTopics = $course->getRawOriginal('topics');
    $topicsFallback = is_array($rawTopics) ? $rawTopics : (is_string($rawTopics) ? (json_decode($rawTopics, true) ?: []) : []);

    $titleEs = old('title_es', data_get($translations, 'es.title', $course->getRawOriginal('title')));
    $titleEn = old('title_en', data_get($translations, 'en.title', ''));
    $excerptEs = old('excerpt_es', data_get($translations, 'es.excerpt', $course->getRawOriginal('excerpt')));
    $excerptEn = old('excerpt_en', data_get($translations, 'en.excerpt', ''));
    $descriptionEs = old('description_es', data_get($translations, 'es.description', $course->getRawOriginal('description')));
    $descriptionEn = old('description_en', data_get($translations, 'en.description', ''));
    $audienceEs = old('audience_es', data_get($translations, 'es.audience', $course->getRawOriginal('audience')));
    $audienceEn = old('audience_en', data_get($translations, 'en.audience', ''));
    $durationEs = old('duration_es', data_get($translations, 'es.duration', $course->getRawOriginal('duration')));
    $durationEn = old('duration_en', data_get($translations, 'en.duration', ''));
    $topicsEs = old('topics_es', implode("\n", data_get($translations, 'es.topics', $topicsFallback)));
    $topicsEn = old('topics_en', implode("\n", data_get($translations, 'en.topics', [])));
@endphp

<div class="row g-4">
    <div class="col-12 d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div>
            <div class="text-uppercase muted small fw-bold mb-2">ES / EN</div>
            <h2 class="h4 text-white mb-0">Curso bilingüe</h2>
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
                    <label for="audience_es" class="form-label">Audiencia</label>
                    <input type="text" class="form-control" id="audience_es" name="audience_es" value="{{ $audienceEs }}" maxlength="190" required>
                </div>

                <div>
                    <label for="duration_es" class="form-label">Duración</label>
                    <input type="text" class="form-control" id="duration_es" name="duration_es" value="{{ $durationEs }}" maxlength="120" required>
                </div>

                <div>
                    <label for="topics_es" class="form-label">Temas</label>
                    <textarea class="form-control" id="topics_es" name="topics_es" rows="8" placeholder="Un tema por línea" required>{{ $topicsEs }}</textarea>
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
                    <label for="audience_en" class="form-label">Audience</label>
                    <input type="text" class="form-control" id="audience_en" name="audience_en" value="{{ $audienceEn }}" maxlength="190" required>
                </div>

                <div>
                    <label for="duration_en" class="form-label">Duration</label>
                    <input type="text" class="form-control" id="duration_en" name="duration_en" value="{{ $durationEn }}" maxlength="120" required>
                </div>

                <div>
                    <label for="topics_en" class="form-label">Topics</label>
                    <textarea class="form-control" id="topics_en" name="topics_en" rows="8" placeholder="One topic per line" required>{{ $topicsEn }}</textarea>
                </div>
            </div>
        </div>
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
    <span class="muted">Los cursos publicados aparecen en la página de cursos y en su página individual.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        @if ($course->exists)
            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">Vista previa</a>
        @endif
        <button type="submit" class="btn btn-admin">Guardar curso</button>
    </div>
</div>