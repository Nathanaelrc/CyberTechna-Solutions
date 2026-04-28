<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Services\GoogleMeetService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleMeetServiceTest extends TestCase
{
    public function test_it_builds_google_meet_payload_from_course_schedule(): void
    {
        config()->set('services.google.meet_timezone', 'America/Santo_Domingo');

        $course = new Course([
            'title' => 'Curso DFIR',
            'excerpt' => 'Simulación guiada para respuesta a incidentes.',
            'delivery_mode' => 'remote',
            'next_session_at' => Carbon::parse('2026-07-10 15:00:00', 'America/Santo_Domingo')->utc(),
            'session_timezone' => 'America/Santo_Domingo',
            'session_length_minutes' => 120,
            'meeting_provider' => 'google_meet',
        ]);

        $payload = app(GoogleMeetService::class)->buildEventPayload($course);

        self::assertSame('Curso DFIR', $payload['summary']);
        self::assertSame('America/Santo_Domingo', $payload['start']['timeZone']);
        self::assertSame('America/Santo_Domingo', $payload['end']['timeZone']);
        self::assertStringContainsString('Modalidad: Remoto en vivo', $payload['description']);
    }

    public function test_it_creates_meet_link_via_google_calendar(): void
    {
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');
        config()->set('services.google.calendar_id', 'calendar@example.com');
        config()->set('services.google.meet_timezone', 'UTC');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'token-123',
            ], 200),
            'https://www.googleapis.com/calendar/v3/calendars/*/events*' => Http::response([
                'id' => 'evt-123',
                'htmlLink' => 'https://calendar.google.com/event?evt=123',
                'conferenceData' => [
                    'entryPoints' => [
                        [
                            'entryPointType' => 'video',
                            'uri' => 'https://meet.google.com/test-meet-link',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $course = new Course([
            'title' => 'Curso DFIR',
            'excerpt' => 'Simulación guiada para respuesta a incidentes.',
            'delivery_mode' => 'remote',
            'next_session_at' => Carbon::parse('2026-07-10 15:00:00', 'UTC'),
            'session_timezone' => 'UTC',
            'session_length_minutes' => 120,
            'meeting_provider' => 'google_meet',
        ]);

        $result = app(GoogleMeetService::class)->createMeetEventForCourse($course);

        self::assertSame('https://meet.google.com/test-meet-link', $result['meet_url']);
        self::assertSame('evt-123', $result['event_id']);
        self::assertSame('calendar@example.com', $result['calendar_id']);
    }
}