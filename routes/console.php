<?php

use App\Models\Course;
use App\Services\GoogleMeetService;
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
