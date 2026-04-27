<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_an_xml_sitemap_with_public_content(): void
    {
        config()->set('app.url', 'https://cybertechnasolutions.com');

        Service::query()->create([
            'title' => 'Pentesting web',
            'slug' => 'pentesting-web',
            'excerpt' => 'Evaluacion ofensiva de aplicaciones.',
            'description' => 'Detalle del servicio.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        Course::query()->create([
            'title' => 'Curso SOC',
            'slug' => 'curso-soc',
            'excerpt' => 'Formacion para analistas.',
            'description' => 'Contenido del curso.',
            'audience' => 'Analistas',
            'duration' => '8 horas',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $author = User::factory()->create();

        Post::query()->create([
            'user_id' => $author->id,
            'title' => 'Hardening inicial',
            'slug' => 'hardening-inicial',
            'excerpt' => 'Guia breve.',
            'content' => 'Contenido del insight.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::query()->create([
            'user_id' => $author->id,
            'title' => 'Borrador interno',
            'slug' => 'borrador-interno',
            'excerpt' => 'No debe salir.',
            'content' => 'Contenido privado.',
            'status' => 'draft',
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        self::assertStringContainsString('application/xml', (string) $response->headers->get('content-type'));
        $response->assertSee('https://cybertechnasolutions.com/servicios/pentesting-web', false);
        $response->assertSee('https://cybertechnasolutions.com/cursos/curso-soc', false);
        $response->assertSee('https://cybertechnasolutions.com/insights/hardening-inicial', false);
        $response->assertDontSee('borrador-interno', false);
    }

    public function test_plural_sitemaps_alias_redirects_to_canonical_sitemap(): void
    {
        $response = $this->get('/sitemaps.xml');

        $response->assertOk();
        self::assertStringContainsString('application/xml', (string) $response->headers->get('content-type'));
    }
}