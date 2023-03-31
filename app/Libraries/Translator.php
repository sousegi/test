<?php

namespace App\Libraries;

use App\Models\Language;
use Carbon\Carbon;

class Translator
{
    const CACHE_NAME = 'translations';

    protected $translations;
    protected $fallback_locale;
    protected $current_locale;
    protected $languages;
    protected $debug;

    public function __construct($fallback_locale = false, $current_locale = false)
    {
        $this->languages = Language::where('site', 1)->get()->pluck('locale', 'locale');

        $this->current_locale = $current_locale;// ?? app()->getLocale() ?? config('amigo.languages.default_locale');
        if (empty($this->current_locale)) {
            $this->current_locale = app()->getLocale();
        }
        if (empty($this->current_locale)) {
            $this->current_locale = config('amigo.languages.default_locale');
        }

        $this->fallback_locale = $fallback_locale;// ?? config('amigo.languages.fallback_locale');
        if (empty($this->fallback_locale)) {
            $this->fallback_locale = config('amigo.languages.fallback_locale');
        }

        $this->debug = config('amigo.languages.debug');
        //\Cache::clear();
        if ($this->debug) {
            if (!in_array($this->current_locale, $this->languages)) {
                throw new \Exception('Default locale not found in site language list');
            }

            if (!in_array($this->fallback_locale, $this->languages)) {
                throw new \Exception('Fallback locale not found in site language list');
            }
        }
        $this->translations = $this->initLanguageCache();
    }

    public function initLanguageCache(): array
    {
        $list = \DB::table('translations')->get();

        $translations = [];

        foreach ($list as $language_line) {
            foreach ($this->languages as $language) {
                $translation_values = json_decode($language_line->content, true);
                $translations[$language][$language_line->key] = $translation_values[$language] ?? '';// ?? $translation_values[$this->fallback_locale] ?? $language_line->original_key;
                if (empty($translations[$language][$language_line->key])) {
                    $translations[$language][$language_line->key] = $translation_values[$this->fallback_locale] ?? '';
                }
                if (empty($translations[$language][$language_line->key])) {
                    $translations[$language][$language_line->key] = $language_line->original_key;
                }
            }
        }

        return $translations;
    }

    public function manage($original_key, $requested_locale = false)
    {
        $formatted_key = \Str::slug($original_key);

        $locale = $requested_locale;
        if (!$locale) {
            $locale = $this->current_locale;
        }

        if (empty($this->languages[$locale])) {
            if ($this->debug) {
                throw new \Exception('Language not found in translations collection');
            } else {
                return $original_key;
            }
        }

        if (empty($this->translations[$locale][$formatted_key])) {
            $this->save($formatted_key, $original_key, [], $locale);
        }

        return $this->translations[$locale][$formatted_key];
    }

    public function save($formatted_key, $original_key, $values = [], $locale)
    {
        $formated_values = [];

        foreach ($this->languages as $language) {
            $formated_values[$language] = $values[$language] ?? '';
            $this->translations[$language][$formatted_key] = $formated_values[$language] ?? $original_key;
        }

        $translation = [
            'key' => $formatted_key,
            'original_key' => $original_key,
            'content' => json_encode($formated_values, JSON_UNESCAPED_UNICODE),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        try {
            \DB::table('translations')->insert($translation);
        } catch (\Exception $e) {
            if ($this->debug) {
                throw new \Exception('Failed to add translation to DB');
            }
        }
        $this->translations[$locale][$formatted_key] = $original_key;
    }

    public function getTranslations($language = false)
    {
        if (!$language) {
            return collect($this->translations);
        }

        try {
            return collect($this->translations[strtolower($language)]);
        } catch (\Exception $e) {
            throw new \Exception('Language not found');
        }
    }

}
