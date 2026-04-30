<?php

namespace App\Services;

use Illuminate\Translation\Translator as BaseTranslator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Throwable;

class AutoTranslator extends BaseTranslator
{
    private array $runtimeTranslations = [];

    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $locale ??= $this->locale;

        if (! is_string($key) || trim($key) === '') {
            return parent::get($key, $replace, $locale, $fallback);
        }

        $cachedTranslation = $this->cachedTranslation($locale, $key);

        if (is_string($cachedTranslation) && $cachedTranslation !== '') {
            return $this->makeReplacements($cachedTranslation, $replace);
        }

        $result = parent::get($key, $replace, $locale, $fallback);

        if (! $this->shouldAutoTranslate($key, $result, $locale)) {
            return $result;
        }

        try {
            $translated = $this->translate($key, $locale);

            if (! is_string($translated) || trim($translated) === '' || $translated === $key) {
                return $result;
            }

            $this->storeTranslation($locale, $key, $translated);

            return $this->makeReplacements($translated, $replace);
        } catch (Throwable $e) {
            Log::warning("Failed to auto-translate '{$key}': " . $e->getMessage());
        }

        return $result;
    }

    private function shouldAutoTranslate(string $key, mixed $result, string $locale): bool
    {
        if (! is_string($result) || $result !== $key) {
            return false;
        }

        if ($locale === config('app.fallback_locale', config('app.locale', 'es'))) {
            return false;
        }

        if (str_contains($key, '.') && ! str_contains($key, ' ')) {
            return false;
        }

        return true;
    }

    private function translate(string $key, string $locale): string
    {
        $translator = new GoogleTranslate($locale, config('app.fallback_locale', 'es'));

        return (string) $translator->translate($key);
    }

    private function cachedTranslation(string $locale, string $key): ?string
    {
        $runtime = data_get($this->runtimeTranslations, $locale.'.'.$key);

        if (is_string($runtime) && $runtime !== '') {
            return $runtime;
        }

        $cached = Cache::get($this->cacheKey($locale, $key));

        if (is_string($cached) && $cached !== '') {
            data_set($this->runtimeTranslations, $locale.'.'.$key, $cached);

            return $cached;
        }

        return null;
    }

    private function storeTranslation(string $locale, string $key, string $translated): void
    {
        data_set($this->runtimeTranslations, $locale.'.'.$key, $translated);

        Cache::put($this->cacheKey($locale, $key), $translated, now()->addDays(30));

        $this->persistToLangFile($locale, $key, $translated);
    }

    private function persistToLangFile(string $locale, string $key, string $translated): void
    {
        $path = base_path("lang/{$locale}.json");
        $translations = [];

        if (! $this->langFileIsWritable($path)) {
            return;
        }

        if (File::exists($path)) {
            $translations = json_decode(File::get($path), true) ?? [];
        }

        if (!isset($translations[$key])) {
            $translations[$key] = $translated;
            ksort($translations);
            File::put($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
    }

    private function langFileIsWritable(string $path): bool
    {
        if (File::exists($path)) {
            return is_writable($path);
        }

        return is_writable(dirname($path));
    }

    private function cacheKey(string $locale, string $key): string
    {
        return 'auto_translation.'.$locale.'.'.sha1($key);
    }
}
