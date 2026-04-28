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
    $deliveryMode = old('delivery_mode', $course->delivery_mode ?? 'remote');
    $meetingProvider = old('meeting_provider', $course->meeting_provider ?? 'none');
    $nextSessionAt = old('next_session_at', $course->nextSessionLocal()?->format('Y-m-d\TH:i'));
    $sessionTimezone = old('session_timezone', $course->session_timezone ?? config('services.google.meet_timezone', 'UTC'));
    $sessionLengthMinutes = old('session_length_minutes', $course->session_length_minutes ?? 90);
    $registrationUrl = old('registration_url', $course->registration_url);
    $googleMeetUrl = data_get($course->googleMeetData(), 'meet_url');
    $googleEventId = data_get($course->googleMeetData(), 'event_id');
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

    <div class="col-12">
        <div class="admin-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-3">
                <div>
                    <div class="text-uppercase muted small fw-bold mb-2">Operación</div>
                    <h3 class="h5 text-white mb-0">Clases, registro e integraciones</h3>
                </div>
                <span class="badge text-bg-dark rounded-pill px-3 py-2">Google Meet y herramientas externas</span>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="delivery_mode" class="form-label">Modalidad</label>
                    <select class="form-select" id="delivery_mode" name="delivery_mode" required>
                        <option value="remote" @selected($deliveryMode === 'remote')>Remoto en vivo</option>
                        <option value="hybrid" @selected($deliveryMode === 'hybrid')>Híbrido</option>
                        <option value="onsite" @selected($deliveryMode === 'onsite')>Presencial</option>
                        <option value="custom" @selected($deliveryMode === 'custom')>A medida</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="meeting_provider" class="form-label">Herramienta principal</label>
                    <select class="form-select" id="meeting_provider" name="meeting_provider" required>
                        <option value="none" @selected($meetingProvider === 'none')>Sin herramienta fija</option>
                        <option value="google_meet" @selected($meetingProvider === 'google_meet')>Google Meet</option>
                        <option value="zoom" @selected($meetingProvider === 'zoom')>Zoom</option>
                        <option value="teams" @selected($meetingProvider === 'teams')>Microsoft Teams</option>
                        <option value="custom" @selected($meetingProvider === 'custom')>Herramienta del cliente</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="session_length_minutes" class="form-label">Duración operativa</label>
                    <input type="number" class="form-control" id="session_length_minutes" name="session_length_minutes" min="30" max="720" value="{{ $sessionLengthMinutes }}" placeholder="90">
                </div>

                <div class="col-md-5">
                    <label for="next_session_at" class="form-label">Próxima edición</label>
                    <input type="datetime-local" class="form-control" id="next_session_at" name="next_session_at" value="{{ $nextSessionAt }}">
                </div>

                <div class="col-md-3">
                    <label for="session_timezone" class="form-label">Zona horaria</label>
                    <input type="text" class="form-control" id="session_timezone" name="session_timezone" value="{{ $sessionTimezone }}" placeholder="UTC">
                </div>

                <div class="col-md-4">
                    <label for="registration_url" class="form-label">URL de registro o reserva</label>
                    <input type="url" class="form-control" id="registration_url" name="registration_url" value="{{ $registrationUrl }}" placeholder="https://...">
                </div>
            </div>

            <div class="mt-4 pt-4 border-top border-secondary-subtle">
                <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center gap-3">
                    <div>
                        <div class="text-uppercase muted small fw-bold mb-2">Google Meet</div>
                        <p class="muted mb-0">Si configuras credenciales de Google Calendar puedes generar el enlace Meet desde aquí y seguir usando este bloque para otras herramientas más adelante.</p>
                    </div>

                    @if ($course->exists)
                        @if ($googleMeetConfigured)
                            <form method="POST" action="{{ route('admin.courses.google-meet', $course) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-signal-soft">Generar enlace Google Meet</button>
                            </form>
                        @else
                            <span class="muted small">Faltan GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REFRESH_TOKEN o GOOGLE_CALENDAR_ID en el entorno.</span>
                        @endif
                    @else
                        <span class="muted small">Guarda el curso primero para generar su enlace de Google Meet.</span>
                    @endif
                </div>

                @if ($googleMeetUrl)
                    <div class="row g-3 mt-1">
                        <div class="col-lg-8">
                            <label for="google_meet_url" class="form-label mt-3">Enlace Meet generado</label>
                            <input type="url" class="form-control" id="google_meet_url" value="{{ $googleMeetUrl }}" readonly>
                        </div>

                        <div class="col-lg-4">
                            <label for="google_event_id" class="form-label mt-3">Google Event ID</label>
                            <input type="text" class="form-control" id="google_event_id" value="{{ $googleEventId }}" readonly>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mt-4">
    <span class="muted">Los cursos publicados aparecen en la página de cursos, su página individual y pueden mostrar próxima edición, modalidad e integración operativa.</span>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-light rounded-pill px-4">Cancelar</a>
        @if ($course->exists)
            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-light rounded-pill px-4" target="_blank" rel="noreferrer">Vista previa</a>
        @endif
        <button type="submit" class="btn btn-admin">Guardar curso</button>
    </div>
</div>