<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CoursePortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_course_portal_and_join_link(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $course = Course::query()->create([
            'title' => 'Curso Blue Team',
            'slug' => 'curso-blue-team',
            'excerpt' => 'Preparación operativa para analistas.',
            'description' => 'Curso centrado en detección y respuesta.',
            'audience' => 'Analistas SOC',
            'duration' => '10 horas',
            'delivery_mode' => 'remote',
            'next_session_at' => Carbon::parse('2026-06-15 10:00:00', 'UTC'),
            'session_timezone' => 'UTC',
            'session_length_minutes' => 120,
            'meeting_provider' => 'google_meet',
            'registration_url' => 'https://registro.example.com/blue-team',
            'integrations' => [
                'google_meet' => [
                    'meet_url' => 'https://meet.google.com/portal-join-link',
                ],
            ],
            'topics' => ['Detección', 'Hunting'],
            'status' => 'published',
            'sort_order' => 1,
            'translations' => [
                'es' => [
                    'title' => 'Curso Blue Team',
                    'excerpt' => 'Preparación operativa para analistas.',
                    'description' => 'Curso centrado en detección y respuesta.',
                    'audience' => 'Analistas SOC',
                    'duration' => '10 horas',
                    'topics' => ['Detección', 'Hunting'],
                ],
                'en' => [
                    'title' => 'Blue Team Course',
                    'excerpt' => 'Operational training for analysts.',
                    'description' => 'Course focused on detection and response.',
                    'audience' => 'SOC analysts',
                    'duration' => '10 hours',
                    'topics' => ['Detection', 'Hunting'],
                ],
            ],
        ]);

        $indexResponse = $this->actingAs($user)->get(route('portal.courses.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Tus cursos y accesos de clase en un solo lugar.');
        $indexResponse->assertSee('Curso Blue Team');

        $showResponse = $this->actingAs($user)->get(route('portal.courses.show', $course));
        $showResponse->assertOk();
        $showResponse->assertSee('Entrar a la clase');
        $showResponse->assertSee('https://meet.google.com/portal-join-link', false);
    }
}