<?php

if (!function_exists('setActive')) {
    function setActive($path, $class = 'active')
    {
        return call_user_func_array('Request::is', (array) $path) ? $class : '';
    }
}

if (!function_exists('settings')) {
    function settings($key)
    {
        if (empty($key)) {
            return '';
        }

        return Illuminate\Support\Facades\Cache::rememberForever("settings.{$key}", function () use ($key) {
            $setting = App\Models\Setting::where('key', $key)->first();
            return $setting->value ?? '';
        });
    }
}

if (!function_exists('getFavicon')) {
    function getFavicon($dimensions)
    {
        $favicon = settings('site.favicon');

        if (empty($favicon)) {
            return '';
        }

        $arr = explode('/', $favicon);
        $favicon = end($arr);

        return str_replace('_', '-'.$dimensions, $favicon);
    }
}

if (!function_exists('amigoTranslate')) {
    function amigoTranslate($key, $locale = false)
    {
        $language = new App\Libraries\Translator();
        $currentLocale = $locale ?? false;

        return $language->manage($key, $currentLocale);
    }
}
