<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CourseDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_page_shows_schedule_and_registration_without_exposing_meeting_url(): void
    {
        config()->set('services.google.meet_timezone', 'America/Santo_Domingo');

        $course = Course::query()->create([
            'title' => 'Curso de respuesta a incidentes',
            'slug' => 'curso-incidentes',
            'excerpt' => 'Preparación operativa para incidentes.',
            'description' => 'Entrenamiento aplicado para equipos que responden incidentes.',
            'audience' => 'Equipos SOC',
            'duration' => '6 horas',
            'delivery_mode' => 'remote',
            'next_session_at' => Carbon::parse('2026-06-02 09:30:00', 'America/Santo_Domingo')->utc(),
            'session_timezone' => 'America/Santo_Domingo',
            'session_length_minutes' => 90,
            'meeting_provider' => 'google_meet',
            'registration_url' => 'https://registro.cybertechna.test/curso-incidentes',
            'topics' => ['Triage', 'Contención'],
            'status' => 'published',
            'sort_order' => 1,
            'integrations' => [
                'google_meet' => [
                    'meet_url' => 'https://meet.google.com/privado-no-publicar',
                ],
            ],
            'translations' => [
                'es' => [
                    'title' => 'Curso de respuesta a incidentes',
                    'excerpt' => 'Preparación operativa para incidentes.',
                    'description' => 'Entrenamiento aplicado para equipos que responden incidentes.',
                    'audience' => 'Equipos SOC',
                    'duration' => '6 horas',
                    'topics' => ['Triage', 'Contención'],
                ],
                'en' => [
                    'title' => 'Incident response course',
                    'excerpt' => 'Operational readiness for incidents.',
                    'description' => 'Applied training for teams responding to incidents.',
                    'audience' => 'SOC teams',
                    'duration' => '6 hours',
                    'topics' => ['Triage', 'Containment'],
                ],
            ],
        ]);

        $response = $this->get(route('courses.show', $course));

        $response->assertOk();
        $response->assertSee('Próxima edición');
        $response->assertSee('Google Meet');
        $response->assertSee('Reservar cupo');
        $response->assertSee('https://registro.cybertechna.test/curso-incidentes', false);
        $response->assertDontSee('https://meet.google.com/privado-no-publicar', false);
    }
}