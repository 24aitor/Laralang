<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Builder\ApertiumTrans;
use Aitor24\Laralang\Builder\GoogleTrans;
use Aitor24\Laralang\Builder\MymemoryTrans;
use Aitor24\Laralang\Models\DB_Translation;

class Builder
{
    /**
     * Get the translation.
     *
     * @param string $string
     *
     * @return object
     */
    public static function trans($string, $vars = [])
    {
        $translator = config('laralang.default.translator');
        if (!in_array(config('laralang.default.translator'), ['apertium', 'mymemory', 'google'])) {
            return "<font style='color:red;'>Laralang doesn't support $translator translator. Check config</font>";
        } else {
            if (config('laralang.default.translator') == 'mymemory') {
                return new MymemoryTrans($string, $vars);
            } elseif (config('laralang.default.translator') == 'apertium') {
                return new ApertiumTrans($string, $vars);
            } elseif (config('laralang.default.translator') == 'google') {
                return new GoogleTrans($string, $vars);
            }
        }
    }

    /**
     * Generate files json for a specify package.
     *
     * @param string $string
     *
     * @return object
     */
    public static function generateTranslations($is_package, $package, $translationsPath, $toLangs = 'es')
    {
        if ($is_package) {
            $path = realpath(__DIR__.'./../../../'.$package.$translationsPath);
        } else {
            $path = resource_path().'/'.$translationsPath;
        }
        $toLangs = explode('|', $toLangs);
        $files = glob($path.'/*.php');
        foreach ($files as $file) {
            foreach ($toLangs as $lang) {
                $lines = include $file;
                $array = self::transArray($lines, $lang);
                $data = '<?php return '.str_replace(')', ']', str_replace('array (', '[', str_replace(")'", ']', str_replace("'array (", '[', $array)))).";\n";

                $savePath = $path.'./../'.$lang.'/';
                if (!file_exists($savePath)) {
                    mkdir($savePath, 0777, true);
                }
                file_put_contents($savePath.basename($file), $data);
            }
        }
    }

    private static function transArray($array, $lang)
    {
        foreach ($array as $var => $text) {
            $vars = [];
            if (is_array($text)) {
                $array[$var] = self::transArray($text, $lang);
            } else {
                foreach (explode(' ', $text) as $word) {
                    if (substr($word, 0, 1) == ':' && !in_array($word, $vars)) {
                        array_push($vars, $word);
                    }
                }
                $entry = $text;
                foreach ($vars as $key => $varreplace) {
                    $entry = str_replace($varreplace, 'VAR_'.$key, $entry);
                }
                $array[$var] = self::trans($entry, $vars)->from('en')->to($lang)->load(false)->Save(false)->__toString();
            }
        }

        return stripslashes(var_export($array, true));
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
}
