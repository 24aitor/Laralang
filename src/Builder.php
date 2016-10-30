<?php

namespace Aitor24\Laralang;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\File;
use App;
class Builder
{
    /**
     * Return a new translation.
     *
     * @param string $string
     * @param string $from
	 * @param string $to
     */
    public static function trans($string, $from = null, $to = null)
    {
        // Setup default values if needed

        if (!$from) {
            $from = App::getLocale();
        }

        if (!$to) {
            $to = 'en';
        }

        // Return the value if the lenguage is the same

        if ($from == $to) {
            return $string;
        }

        // Check if it can be translated from online sources.

        $domain = "api.apertium.org";
        $string = str_replace(' ', '%20', $string);

        if (gethostbyname($domain) != $domain) {

            $url = "http://$domain/json/translate?q=$string&langpair=$from%7C$to";
            $json = file_get_contents($url);
            $data = json_decode($json);

            if ($data->responseStatus != 200) {
                return $string;
            }

            $translation =  str_replace('_', ' ', $data->responseData->translatedText);
            return ucfirst(strtolower(str_replace('*', '', $translation)));

        }

        // Returns the string without changes because all translations methods failed.

        return $string;
    }
}
