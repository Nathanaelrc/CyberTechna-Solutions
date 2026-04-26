<?php

namespace App\Models\Concerns;

trait HasLocalizedContent
{
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