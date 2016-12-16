<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Builder\ApertiumTrans;
use Aitor24\Laralang\Builder\GoogleTrans;
use Aitor24\Laralang\Builder\MymemoryTrans;
use Aitor24\Laralang\Models\DB_Translation;
use URL;

class Builder
{
    /**
     * Get the trnaslation.
     *
     * @param string $string
     *
     * @return object
     */
    public static function trans($string)
    {
        $translator = config('laralang.default.translator');
        if (!in_array(config('laralang.default.translator'), ['apertium', 'mymemory', 'google'])) {
            return "<font style='color:red;'>Laralang doesn't support $translator translator. Check config</font>";
        } else {
            if (config('laralang.default.translator') == 'mymemory') {
                return new MymemoryTrans($string);
            } elseif (config('laralang.default.translator') == 'apertium') {
                return new ApertiumTrans($string);
            } elseif (config('laralang.default.translator') == 'google') {
                return new GoogleTrans($string);
            }
        }
    }

    /**
     * Get the languages that translations has been translated.
     *
     * @return array
     */
    public static function toLanguages()
    {
        $locales = [];
        $translations = DB_Translation::distinct()->select('to_lang')->get();
        foreach ($translations as $object) {
            array_push($locales, $object->to_lang);
        }

        return $locales;
    }

    /**
     * Get the languages from translations has been translated.
     *
     * @return array
     */
    public static function fromLanguages()
    {
        $locales = [];
        $translations = DB_Translation::distinct()->select('from_lang')->get();
        foreach ($translations as $object) {
            array_push($locales, $object->from_lang);
        }

        return $locales;
    }

    /**
     * Get all the available languages.
     *
     * @return array
     */
    public static function allLanguages()
    {
        return [
            'en' => 'English',
            'es' => 'Spanish',
            'ca' => 'Catalan',
            'pt' => 'Portuguese',
            'zh' => 'Chinese',
            'ja' => 'Japanese',
            'de' => 'German',
            'fr' => 'French',
            'eu' => 'Basque',
            'ru' => 'Russian',
        ];
    }

    /**
     * Return secure_asset method or asset method depending on config https.
     *
     * @param string $asset
     *
     * @return string
     */
    public static function checkAsset($asset)
    {
        if (config('laralang.default.https')) {
            return secure_asset($asset);
        }

        return asset($asset);
    }

    /**
     * Return secure_url method or url method depending on config https.
     *
     * @param string $url
     *
     * @return string
     */
    public static function checkUrl($url)
    {
        if (config('laralang.default.https')) {
            return secure_url($url);
        }

        return url($url);
    }

    /**
     * Return secure_url method or url method depending on config https.
     *
     * @param string $url
     *
     * @return string
     */
    public static function checkRoute($routeName, $routeArgs = null)
    {
        if (config('laralang.default.https')) {
            if (isset($routeArgs)) {
                return secure_url(URL::route($routeName, $routeArgs, false));
            }

            return secure_url(URL::route($routeName, [], false));
        }
        if (isset($routeArgs)) {
            return route($routeName, $routeArgs);
        }

        return route($routeName);
    }
}
