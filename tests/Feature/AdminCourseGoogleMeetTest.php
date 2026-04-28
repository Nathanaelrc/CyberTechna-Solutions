<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminCourseGoogleMeetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_google_meet_link_for_course(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');
        config()->set('services.google.calendar_id', 'calendar@example.com');
        config()->set('services.google.meet_timezone', 'America/Santo_Domingo');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'token-123',
                'expires_in' => 3600,
            ], 200),
            'https://www.googleapis.com/calendar/v3/calendars/*/events*' => Http::response([
                'id' => 'google-event-1',
                'htmlLink' => 'https://calendar.google.com/calendar/event?eid=1',
                'conferenceData' => [
                    'entryPoints' => [
                        [
                            'entryPointType' => 'video',
                            'uri' => 'https://meet.google.com/abc-defg-hij',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $course = Course::query()->create([
            'title' => 'Curso SOC',
            'slug' => 'curso-soc',
            'excerpt' => 'Formación práctica para analistas.',
            'description' => 'Detalle del curso.',
            'audience' => 'Analistas',
            'duration' => '8 horas',
            'delivery_mode' => 'remote',
            'next_session_at' => Carbon::parse('2026-05-20 14:00:00', 'America/Santo_Domingo')->utc(),
            'session_timezone' => 'America/Santo_Domingo',
            'session_length_minutes' => 120,
            'meeting_provider' => 'google_meet',
            'topics' => ['Detección', 'Respuesta'],
            'status' => 'published',
            'sort_order' => 1,
            'translations' => [
                'es' => [
                    'title' => 'Curso SOC',
                    'excerpt' => 'Formación práctica para analistas.',
                    'description' => 'Detalle del curso.',
                    'audience' => 'Analistas',
                    'duration' => '8 horas',
                    'topics' => ['Detección', 'Respuesta'],
                ],
                'en' => [
                    'title' => 'SOC Course',
                    'excerpt' => 'Hands-on training for analysts.',
                    'description' => 'Course detail.',
                    'audience' => 'Analysts',
                    'duration' => '8 hours',
                    'topics' => ['Detection', 'Response'],
                ],
            ],
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.courses.edit', $course))
            ->patch(route('admin.courses.google-meet', $course));

        $response->assertRedirect(route('admin.courses.edit', $course));
        $response->assertSessionHas('status', 'Enlace de Google Meet generado correctamente.');

        $freshCourse = $course->fresh();

        self::assertSame('https://meet.google.com/abc-defg-hij', data_get($freshCourse->integrations, 'google_meet.meet_url'));
        self::assertSame('google-event-1', data_get($freshCourse->integrations, 'google_meet.event_id'));
    }
}