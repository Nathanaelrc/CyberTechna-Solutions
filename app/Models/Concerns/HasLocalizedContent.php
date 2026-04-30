<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

trait HasLocalizedContent
{
    public static function bootHasLocalizedContent(): void
    {
        static::saving(function ($model): void {
            $model->syncAutoTranslations();
        });
    }

    public function syncAutoTranslations(?string $targetLocale = null, ?string $fallbackLocale = null): bool
    {
        if (app()->runningUnitTests()) {
            return false;
        }

        $targetLocale ??= 'en';
        $fallbackLocale ??= config('app.fallback_locale', config('app.locale', 'es'));

        if ($targetLocale === $fallbackLocale) {
            return false;
        }

        $translations = is_array($this->translations) ? $this->translations : [];
        $translator = new GoogleTranslate($targetLocale, $fallbackLocale);
        $didChange = false;

        foreach ($this->translatableScalarFields() as $field) {
            if (! $this->shouldTranslateField($field, $translations, $targetLocale)) {
                continue;
            }

            $rawValue = $this->getAttributes()[$field] ?? null;

            try {
                $translated = (string) $translator->translate((string) $rawValue);
            } catch (Throwable $e) {
                Log::warning("Auto-translate failed for {$field}: " . $e->getMessage());
                continue;
            }

            if ($translated === '') {
                continue;
            }

            if (data_get($translations, "{$targetLocale}.{$field}") !== $translated) {
                data_set($translations, "{$targetLocale}.{$field}", $translated);
                $didChange = true;
            }
        }

        foreach ($this->translatableArrayFields() as $field) {
            if (! $this->shouldTranslateField($field, $translations, $targetLocale)) {
                continue;
            }

            $rawValue = $this->getAttributes()[$field] ?? null;
            $values = is_array($rawValue) ? $rawValue : json_decode((string) $rawValue, true);

            if (! is_array($values) || $values === []) {
                continue;
            }

            try {
                $translated = collect($values)
                    ->map(fn ($value) => is_string($value) && $value !== '' ? (string) $translator->translate($value) : $value)
                    ->all();
            } catch (Throwable $e) {
                Log::warning("Auto-translate failed for array {$field}: " . $e->getMessage());
                continue;
            }

            if (data_get($translations, "{$targetLocale}.{$field}") !== $translated) {
                data_set($translations, "{$targetLocale}.{$field}", $translated);
                $didChange = true;
            }
        }

        if ($didChange) {
            $this->translations = $translations;
        }

        return $didChange;
    }

    protected function translatableScalarFields(): array
    {
        return ['title', 'excerpt', 'description', 'content', 'audience', 'duration'];
    }

    protected function translatableArrayFields(): array
    {
        return ['deliverables', 'details', 'topics'];
    }

    protected function shouldTranslateField(string $field, array $translations, string $targetLocale): bool
    {
        if (! array_key_exists($field, $this->getAttributes())) {
            return false;
        }

        $rawValue = $this->getAttributes()[$field] ?? null;

        if ($rawValue === null || $rawValue === '' || $rawValue === []) {
            return false;
        }

        if ($this->isDirty($field)) {
            return true;
        }

        $existing = data_get($translations, "{$targetLocale}.{$field}");

        return $existing === null || $existing === '' || $existing === [];
    }

    public function translation(string $field, ?string $locale = null, mixed $default = null): mixed
    {
        $locale ??= app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', config('app.locale'));
        $translations = $this->translations ?? [];

        $value = data_get($translations, $locale.'.'.$field);

        if ($value === null || $value === '') {
            $value = data_get($translations, $fallbackLocale.'.'.$field);
        }

        return $value === null || $value === '' ? $default : $value;
    }

    public function translationLines(string $field, ?string $locale = null): array
    {
        $value = $this->translation($field, $locale);

        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            return collect(preg_split('/\r\n|\r|\n/', $value))
                ->map(fn ($line) => trim((string) $line))
                ->filter()
                ->values()
                ->all();
        }

        return [];
    }

    protected function localizedScalar(string $field, mixed $default): mixed
    {
        $translated = $this->translation($field);

        return $translated ?? $default;
    }

    protected function localizedArray(string $field, mixed $default): array
    {
        $translated = $this->translation($field);

        if (is_array($translated)) {
            return $translated;
        }

        if (is_string($translated) && $translated !== '') {
            return collect(preg_split('/\r\n|\r|\n/', $translated))
                ->map(fn ($line) => trim((string) $line))
                ->filter()
                ->values()
                ->all();
        }

        if (is_array($default)) {
            return $default;
        }

        if (is_string($default) && $default !== '') {
            $decoded = json_decode($default, true);

            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }
}