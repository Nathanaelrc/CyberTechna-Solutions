<?php

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use App\Services\GoogleMeetService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

$readBootstrapState = fn (string $name): array => Cache::get('bootstrap_state.'.$name, []);

$writeBootstrapState = function (string $name, array $state): void {
    Cache::forever('bootstrap_state.'.$name, $state);
};

$fileSignature = function (array $paths): string {
    $files = collect($paths)
        ->filter(fn (string $path) => File::exists($path))
        ->flatMap(fn (string $path) => collect(File::allFiles($path)))
        ->filter(fn ($file) => $file->getExtension() === 'php')
        ->sortBy(fn ($file) => $file->getPathname())
        ->values();

    $snapshot = $files->map(fn ($file) => [
        'path' => $file->getPathname(),
        'mtime' => $file->getMTime(),
        'size' => $file->getSize(),
    ])->all();

    return sha1(json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
};

$extractTranslationKeys = function (array $paths) {
    return collect($paths)
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
};

$seedSignature = function () use ($fileSignature): string {
    return sha1(json_encode([
        'seeders' => $fileSignature([database_path('seeders')]),
        'admin' => [
            'email' => env('ADMIN_EMAIL', 'm.rodriguez@cybertechnasolutions.com'),
            'name' => env('ADMIN_NAME', 'CyberTechna Owner'),
            'password' => env('ADMIN_PASSWORD', 'change-me-please'),
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
};

$translationSignature = function (string $locale) use ($fileSignature): string {
    $modelState = collect([Service::class, Course::class, Post::class])
        ->mapWithKeys(function (string $modelClass) {
            $model = new $modelClass();
            $updatedAtColumn = $model->getUpdatedAtColumn();

            return [
                $modelClass => [
                    'count' => $modelClass::query()->count(),
                    'max_updated_at' => $updatedAtColumn ? $modelClass::query()->max($updatedAtColumn) : null,
                ],
            ];
        })
        ->all();

    return sha1(json_encode([
        'locale' => $locale,
        'files' => $fileSignature([app_path(), resource_path('views'), base_path('routes')]),
        'models' => $modelState,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
};

$seedRequired = function (): bool {
    return ! User::query()->where('is_admin', true)->exists()
        || ! Service::query()->exists()
        || ! Course::query()->exists();
};

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

Artisan::command('translations:warm {--locale=en : Locale a precalentar} {--force : Obliga el precalentamiento aunque no haya cambios}', function () use ($extractTranslationKeys, $readBootstrapState, $translationSignature, $writeBootstrapState) {
    $locale = (string) $this->option('locale');
    $paths = [
        app_path(),
        resource_path('views'),
        base_path('routes'),
    ];

    $currentSignature = $translationSignature($locale);
    $savedState = $readBootstrapState('translations-'.$locale.'.json');

    if (! $this->option('force') && ($savedState['signature'] ?? null) === $currentSignature) {
        $this->info('Precalentamiento de traducciones omitido: sin cambios detectados.');

        return;
    }

    $strings = $extractTranslationKeys($paths);

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

    $writeBootstrapState('translations-'.$locale.'.json', [
        'signature' => $translationSignature($locale),
        'locale' => $locale,
        'strings' => $strings->count(),
        'updated_models' => $updatedModels,
        'warmed_at' => now()->toAtomString(),
    ]);
})->purpose('Genera y almacena traducciones faltantes para un locale.');

Artisan::command('app:bootstrap {--locale=en : Locale a precalentar} {--force-seed : Fuerza el seeding} {--force-translations : Fuerza el precalentamiento}', function () use ($readBootstrapState, $seedRequired, $seedSignature, $writeBootstrapState) {
    $locale = (string) $this->option('locale');
    $currentSeedSignature = $seedSignature();
    $savedSeedState = $readBootstrapState('seed.json');

    $shouldSeed = $this->option('force-seed')
        || $seedRequired()
        || ($savedSeedState['signature'] ?? null) !== $currentSeedSignature;

    if ($shouldSeed) {
        $this->call('db:seed', ['--force' => true]);

        $writeBootstrapState('seed.json', [
            'signature' => $currentSeedSignature,
            'seeded_at' => now()->toAtomString(),
        ]);
    } else {
        $this->info('Seeding omitido: sin cambios detectados.');
    }

    $translationOptions = ['--locale' => $locale];

    if ($this->option('force-translations')) {
        $translationOptions['--force'] = true;
    }

    $this->call('translations:warm', $translationOptions);
})->purpose('Ejecuta solo el bootstrap necesario al arrancar la aplicación.');
