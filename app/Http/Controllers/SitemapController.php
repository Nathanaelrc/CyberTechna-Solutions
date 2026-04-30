<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            ['loc' => $this->canonicalUrl('/'), 'lastmod' => null],
            ['loc' => $this->canonicalUrl('/servicios'), 'lastmod' => null],
            ['loc' => $this->canonicalUrl('/metodo'), 'lastmod' => null],
            ['loc' => $this->canonicalUrl('/cursos'), 'lastmod' => null],
            ['loc' => $this->canonicalUrl('/contacto'), 'lastmod' => null],
        ])
            ->concat(
                Service::query()
                    ->where('status', 'published')
                    ->orderBy('sort_order')
                    ->get()
                    ->map(fn (Service $service) => [
                        'loc' => $this->canonicalUrl(route('services.show', ['service' => $service->slug], false)),
                        'lastmod' => $service->updated_at?->toAtomString(),
                    ])
            )
            ->concat(
                Course::query()
                    ->where('status', 'published')
                    ->orderBy('sort_order')
                    ->get()
                    ->map(fn (Course $course) => [
                        'loc' => $this->canonicalUrl(route('courses.show', ['course' => $course->slug], false)),
                        'lastmod' => $course->updated_at?->toAtomString(),
                    ])
            )
            ->concat(
                Post::query()
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->latest('published_at')
                    ->get()
                    ->map(fn (Post $post) => [
                        'loc' => $this->canonicalUrl(route('posts.show', ['post' => $post->slug], false)),
                        'lastmod' => $post->updated_at?->toAtomString(),
                    ])
            );

        return response()
            ->view('sitemap', ['urls' => $urls], 200)
            ->header('Content-Type', 'application/xml');
    }

    private function canonicalUrl(string $path): string
    {
        $root = rtrim((string) config('app.url'), '/');
        $normalizedPath = '/'.ltrim($path, '/');

        return $normalizedPath === '/' ? $root : $root.$normalizedPath;
    }
}
