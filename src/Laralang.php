<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Laralang extends Controller
{

    public static function trans ($string1, $output, $input='en') {
        $domain = "api.apertium.org";
        if (gethostbyname($domain) != $domain) {

            $url = 'http://api.apertium.org/json/translate?q='.str_replace(' ', '%20', $string1).'&langpair='.$input.'%7C'.$output;
            $json = file_get_contents($url);
            $data = json_decode($json);
            if ($data->responseStatus != 200) {
                return $string1;
            } else {
                $translation =  str_replace('_', ' ', $data->responseData->translatedText);
                return ucfirst(strtolower(str_replace('*', '',$translation)));
            }

        } else {
            return $string1;
        }
    }
}
