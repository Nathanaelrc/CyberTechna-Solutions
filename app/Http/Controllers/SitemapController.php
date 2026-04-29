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
            ['loc' => url('/'), 'lastmod' => null],
            ['loc' => url('/servicios'), 'lastmod' => null],
            ['loc' => url('/metodo'), 'lastmod' => null],
            ['loc' => url('/cursos'), 'lastmod' => null],
            ['loc' => url('/contacto'), 'lastmod' => null],
        ])
            ->concat(
                Service::query()
                    ->where('status', 'published')
                    ->orderBy('sort_order')
                    ->get()
                    ->map(fn (Service $service) => [
                        'loc' => route('services.show', ['service' => $service->slug]),
                        'lastmod' => $service->updated_at?->toAtomString(),
                    ])
            )
            ->concat(
                Course::query()
                    ->where('status', 'published')
                    ->orderBy('sort_order')
                    ->get()
                    ->map(fn (Course $course) => [
                        'loc' => route('courses.show', ['course' => $course->slug]),
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
                        'loc' => route('posts.show', ['post' => $post->slug]),
                        'lastmod' => $post->updated_at?->toAtomString(),
                    ])
            );

        return response()
            ->view('sitemap', ['urls' => $urls], 200)
            ->header('Content-Type', 'application/xml');
    }
}
