<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Portal\CoursePortalController;
use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

 $buildSitemap = function (): Response {
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
 };

Route::get('/sitemap.xml', $buildSitemap)->name('sitemap');
Route::get('/sitemaps.xml', $buildSitemap);

Route::middleware('setLocale')->group(function (): void {
    Route::get('/idioma/{locale}', function (string $locale) {
        abort_unless(in_array($locale, ['es', 'en'], true), 404);

        session(['locale' => $locale]);

        return redirect()->back();
    })->name('locale.switch');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/servicios', [HomeController::class, 'services'])->name('services');
    Route::get('/servicios/{service:slug}', [HomeController::class, 'service'])->name('services.show');
    Route::get('/metodo', [HomeController::class, 'method'])->name('method');
    Route::get('/cursos', [HomeController::class, 'courses'])->name('courses');
    Route::get('/cursos/{course:slug}', [HomeController::class, 'course'])->name('courses.show');
    Route::get('/contacto', [HomeController::class, 'contact'])->name('contact');
    Route::get('/insights/{post:slug}', [HomeController::class, 'show'])->name('posts.show');
    Route::post('/contacto', [ContactMessageController::class, 'store'])->name('contact.store');

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        Route::prefix('mi-catalogo')->name('portal.')->group(function () {
            Route::get('/cursos', [CoursePortalController::class, 'index'])->name('courses.index');
            Route::get('/cursos/{course:slug}', [CoursePortalController::class, 'show'])->name('courses.show');
        });
    });

    Route::prefix('panel')
        ->middleware(['auth', 'admin'])
        ->name('admin.')
        ->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/mensajes', [DashboardController::class, 'messages'])->name('messages.index');
            Route::patch('/mensajes/{contactMessage}/review', [DashboardController::class, 'markMessageAsReviewed'])
                ->name('messages.review');
            Route::resource('services', ServiceController::class)->except('show');
            Route::patch('/courses/{course}/google-meet', [CourseController::class, 'syncGoogleMeet'])->name('courses.google-meet');
            Route::resource('courses', CourseController::class)->except('show');
            Route::resource('posts', PostController::class)->except('show');
            Route::resource('users', UserController::class)->except('show');
        });
});
