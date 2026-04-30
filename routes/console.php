<?php

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use App\Services\GoogleMeetService;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('google-meet:test {course : ID del curso} {--create : Crea el evento real en Google Calendar}', function (GoogleMeetService $googleMeetService) {
    $course = Course::query()->findOrFail((int) $this->argument('course'));

    if ($this->option('create')) {
        $result = $googleMeetService->createMeetEventForCourse($course);

        $this->info('Evento creado en Google Calendar.');
        $this->line('Meet: '.($result['meet_url'] ?? 'n/a'));
        $this->line('Google event: '.($result['event_id'] ?? 'n/a'));
        $this->line('HTML: '.($result['html_link'] ?? 'n/a'));

        return;
    }

    $this->line(json_encode($googleMeetService->buildEventPayload($course), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
})->purpose('Previsualiza o crea una reunión de Google Meet para un curso.');

Artisan::command('translations:warm {--locale=en : Locale a precalentar}', function () {
    $locale = (string) $this->option('locale');
    $paths = [
        app_path(),
        resource_path('views'),
        base_path('routes'),
    ];

    $strings = collect($paths)
        ->filter(fn (string $path) => File::exists($path))
        ->flatMap(function (string $path) {
            return collect(File::allFiles($path))
                ->filter(fn ($file) => $file->getExtension() === 'php')
                ->flatMap(function ($file) {
                    $content = File::get($file->getPathname());
                    preg_match_all("/__\(\s*'((?:\\\\'|[^'])+)'/", $content, $singleQuoted);
                    preg_match_all('/__\(\s*"((?:\\\\"|[^"])+)"/', $content, $doubleQuoted);

                    return collect(array_merge($singleQuoted[1] ?? [], $doubleQuoted[1] ?? []))
                        ->map(fn (string $match) => stripcslashes($match));
                });
        })
        ->filter(fn (string $key) => trim($key) !== '')
        ->unique()
        ->values();

    $this->info('Cadenas detectadas: '.$strings->count());

    $translator = app('translator');
    app()->setLocale($locale);

    $strings->each(function (string $key) use ($translator, $locale) {
        $translator->get($key, [], $locale);
    });

    $updatedModels = 0;

    foreach ([Service::class, Course::class, Post::class] as $modelClass) {
        $modelClass::query()->chunkById(100, function ($models) use ($locale, &$updatedModels) {
            foreach ($models as $model) {
                if (! method_exists($model, 'syncAutoTranslations')) {
                    continue;
                }

                if ($model->syncAutoTranslations($locale)) {
                    $model->saveQuietly();
                    $updatedModels++;
                }
            }
        });
    }

    $this->info('Precalentamiento de traducciones finalizado para: '.$locale);
    $this->info('Registros con traducciones actualizadas: '.$updatedModels);
})->purpose('Genera y almacena traducciones faltantes para un locale.');
