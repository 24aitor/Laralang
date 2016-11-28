<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Builder\ApertiumTrans;
use Aitor24\Laralang\Builder\Exception;
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
        if (!in_array(config('laralang.default.translator'), ['apertium', 'mymemory'])) {
            return "<font style='color:red;'>Laralang doesn't support $translator translator. Check config</font>";
        } else {
            if (config('laralang.default.translator') == 'mymemory') {
                return new MymemoryTrans($string);
            } elseif (config('laralang.default.translator') == 'apertium') {
                return new ApertiumTrans($string);
            }
        }
    }

    /**
     * Get the languages used.
     *
     * @return array
     */
    public static function languages()
    {
        $locales = [];
        $translations = DB_Translation::distinct()->select('to_lang')->get();
        foreach ($translations as $object) {
            array_push($locales, $object->to_lang);
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
