<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Builder\ApertiumTrans;
use Aitor24\Laralang\Builder\GoogleTrans;
use Aitor24\Laralang\Builder\MymemoryTrans;
use Aitor24\Laralang\Models\DB_Translation;

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
        return ['English' => 'en', 'Spanish' => 'es', 'Catalan' => 'ca', 'Portuguese' => 'pt', 'Chinese' => 'zh', 'Japanese' => 'ja', 'German' => 'de', 'French' => 'fr'];
    }
}
