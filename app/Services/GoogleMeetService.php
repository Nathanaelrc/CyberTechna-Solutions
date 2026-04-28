<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class GoogleMeetService
{
    public function isConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.refresh_token'))
            && filled(config('services.google.calendar_id'));
    }

    public function buildEventPayload(Course $course): array
    {
        $start = $course->nextSessionLocal();

        if (! $start) {
            throw new RuntimeException('El curso no tiene una próxima edición configurada.');
        }

        if (! $course->session_length_minutes) {
            throw new RuntimeException('Define la duración operativa del curso antes de generar el Meet.');
        }

        $end = $start->copy()->addMinutes($course->session_length_minutes);
        $description = collect([
            $course->excerpt,
            __('Duración estimada').': '.$course->session_length_minutes.' min',
            __('Modalidad').': '.$course->deliveryModeLabel(),
        ])->filter()->implode("\n\n");

        return [
            'summary' => $course->title,
            'description' => $description,
            'start' => [
                'dateTime' => $start->toRfc3339String(),
                'timeZone' => $course->session_timezone ?: config('services.google.meet_timezone', 'UTC'),
            ],
            'end' => [
                'dateTime' => $end->toRfc3339String(),
                'timeZone' => $course->session_timezone ?: config('services.google.meet_timezone', 'UTC'),
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => (string) Str::uuid(),
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
        ];
    }

    public function createMeetEventForCourse(Course $course): array
    {
        if ($course->meeting_provider !== 'google_meet') {
            throw new RuntimeException('Selecciona Google Meet como herramienta principal del curso antes de generar el enlace.');
        }

        if (! $this->isConfigured()) {
            throw new RuntimeException('La integración con Google no está configurada todavía.');
        }

        $payload = $this->buildEventPayload($course);
        $calendarId = (string) config('services.google.calendar_id');
        $url = rtrim((string) config('services.google.calendar_base_url'), '/').'/calendars/'.rawurlencode($calendarId).'/events';

        try {
            $response = Http::acceptJson()
                ->withToken($this->accessToken())
                ->post($url.'?conferenceDataVersion=1', $payload)
                ->throw()
                ->json();
        } catch (RequestException $exception) {
            throw new RuntimeException('Google Calendar rechazó la creación de la reunión. Revisa credenciales, permisos y calendario destino.');
        }

        $meetUrl = collect(data_get($response, 'conferenceData.entryPoints', []))
            ->firstWhere('entryPointType', 'video')['uri']
            ?? data_get($response, 'hangoutLink')
            ?? null;

        if (! $meetUrl) {
            throw new RuntimeException('Google creó el evento, pero no devolvió un enlace de Meet.');
        }

        return [
            'event_id' => data_get($response, 'id'),
            'meet_url' => $meetUrl,
            'html_link' => data_get($response, 'htmlLink'),
            'calendar_id' => $calendarId,
        ];
    }

    private function accessToken(): string
    {
        try {
            $response = Http::asForm()
                ->acceptJson()
                ->post((string) config('services.google.token_url'), [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'refresh_token' => config('services.google.refresh_token'),
                    'grant_type' => 'refresh_token',
                ])
                ->throw()
                ->json();
        } catch (RequestException $exception) {
            throw new RuntimeException('No se pudo autenticar contra Google. Revisa client ID, client secret y refresh token.');
        }

        $token = data_get($response, 'access_token');

        if (! is_string($token) || $token === '') {
            throw new RuntimeException('Google no devolvió un access token válido.');
        }

        return $token;
    }
}