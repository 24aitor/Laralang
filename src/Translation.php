<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Models\DB_Translation;
use App;
use Illuminate\Support\Facades\DB;

class Translation
{
    /**
     * Setup public vars.
     */
    public $translator;
    public $translation;
    public $string;
    public $debug;
    public $from;
    public $to;

    /**
     * Setup default values.
     *
     * @param string $string
     */
    public function __construct($string)
    {
        $this->translator = config('laralang.default.translator');
        $this->debug = config('laralang.default.debug');
        $this->from = config('laralang.default.from_lang');
        $this->to = config('laralang.default.to_lang');
        $this->string = $string;
        $this->translation = $string;


        // Checking whether from_lang or to_lang are set as app_locale.

        if ($this->from == 'app_locale') {
            $this->from = App::getLocale();
        }

        if ($this->to == 'app_locale') {
            $this->to = App::getLocale();
        }
    }

    /**
     * Setup debug value.
     *
     * @param bool $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Setup fromLang value.
     *
     * @param string $lang
     */
    public function setFromLang($lang)
    {
        $this->from = $lang;

        return $this;
    }

    /**
     * Setup tolang value.
     *
     * @param string $lang
     */
    public function setToLang($lang)
    {
        $this->to = $lang;

        return $this;
    }

    /**
     * Setup translator.
     *
     * @param string $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;

        return $this;
    }

    private function exists()
    {
        $existing = DB_Translation::where('string', '=', $this->string)
        ->where('from_lang', '=', $this->from)
        ->where('to_lang', '=', $this->to)
        ->where('translator', '=', $this->translator)->get();

        if (count($existing) == 0) {
            return false;
        }
        if ($this->debug === true) {
            $this->translation = "<font style='color:#00CC00;'>Loaded correclty from you DB</font>";
        } else {
            $this->translation = $existing[0]->translation;
        }

        return true;
    }

    /**
     * Function to save translations to DB.
     */
    private function save()
    {
        $trans = new DB_Translation();
        $trans = new DB_Translation();
        $trans->string = $this->string;
        $trans->from_lang = $this->from;
        $trans->to_lang = $this->to;
        $trans->translator = $this->translator;
        $trans->translation = $this->translation;
        $trans->save();
    }

    /**
     * Main function of the class.
     *
     * Check what translator must select.
     */
    private function run()
    {

        // Return the value if the language is the same.

        if ($this->from == $this->to) {
            if ($this->debug === true) {
                $this->translation = "<font style='color:orange;'>Same in <> out languge</font>";
            }

            return;
        }


        if ($this->exists() === true) {
            return;
        }

        $available_transoltors = ['apertium', 'mymemory'];

        // Checks available translators.

        if (in_array($this->translator, $available_transoltors) == false) {
            if ($this->debug === true) {
                $this->translation = "<font style='color:red;'>Not suported translator: ".$this->translator.'</font>';
            }

            return;
        }

        if ($this->translator == 'apertium') {
            return $this->apertiumTrans();
        } elseif ($this->translator == 'mymemory') {
            return $this->mymemoryTrans();
        }
    }

     /**
      * Get translation from mymemory API.
      */
     private function mymemoryTrans()
     {
         // Check if it can be translated from online sources.

         $host = 'api.mymemory.translated.net';
         if ($socket = @fsockopen($host, 80, $errno, $errstr, 30)) {

             // Host online
             $urlString = urlencode($this->string);
             $url = "http://$host/get?q=$urlString&langpair=$this->from%7C$this->to";
             $json = file_get_contents($url);
             $data = json_decode($json);

             // Checking response status

             if ($data->responseStatus != 200) {
                 if ($this->debug == true) {
                     $details = $data->responseDetails;
                     if ($data->responseStatus == 403) {
                         $details = ($data->responseDetails);
                     }
                     $this->translation = "<font style='color:red;'>Error ".$data->responseStatus.': '.$details.'</font>';
                 }

                 return;
             }


             $transObtained = $data->responseData->translatedText;

             $this->translation = utf8_decode(ucfirst(strtolower(trim($transObtained))));

             $this->save();

             // Checking debug setting to determinate how to output translation

             if ($this->debug === true) {
                 $this->translation = "<font style='color:#00CC00;'>".$this->translation.'</font>';
             }


             return;
             fclose($socket);
         } else {

             //host offline
             $this->hostDown();
         }
     }

    /**
     * Get translation from apertium API.
     */
    private function apertiumTrans()
    {
        // Check if it can be translated from online sources.

        $host = 'api.apertium.org';
        if ($socket = @fsockopen($host, 80, $errno, $errstr, 30)) {

            // Host online

            $urlString = urlencode($this->string);
            $url = "http://$host/json/translate?q=$urlString&langpair=$this->from%7C$this->to";
            $json = file_get_contents($url);
            $data = json_decode($json);

            // Checking response status

            if ($data->responseStatus != 200) {
                if ($this->debug === true) {
                    $this->translation = "<font style='color:red;'>Error ".$data->responseStatus.': '.$data->responseDetails.'</font>';
                }

                return;
            }

            $transObtained = $data->responseData->translatedText;


            $this->translation = ucfirst(strtolower(trim(str_replace('*', ' ', $transObtained))));


            // Checking debug setting to determinate how to output translation

            if ($this->debug === true) {
                $errors = '';
                $words = explode(' ', $transObtained);
                foreach ($words as $word) {
                    if ($word != '') {
                        if ($word[0] == '*') {
                            $errors = $errors.substr($word, 1).', ';
                        }
                    }
                }

                if ($errors == '') {
                    $this->translation = "<font style='color:#00CC00;'>".$this->translation.'</font>';
                } else {
                    $this->translation = "<font style='color:orange;'>Unknoun words: ".substr($errors, 0, -2).'</font>';
                }
            }

            fclose($socket);

            return;
        } else {
            //host offline
            $this->hostDown();
        }
    }

    /*
     * This fuction is called when host is down, and it would set translation if debug is true
     *
     */
    private function hostDown()
    {
        if ($this->debug === true) {
            $this->translation = "<font style='color:red;'>$this->translator host is down</font>";
        }
    }

    /*
     * This fuction is called by trans() function of Fadade Laralang
     * It would call run() function of this class and returns the translation
     *
     */
    public function __toString()
    {
        $this->run();

        return $this->translation;
    }
}
