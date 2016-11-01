<?php

namespace Aitor24\Laralang;

use App;

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
     * @param string $from
     * @param string $to
     */
    public function __construct($string, $from = null, $to = null)
    {
        $this->translator = config('laralang.default.translator');
        $this->debug = config('laralang.default.debug');
        $this->string = $string;
        $this->translation = $string;
        if (!$from) {
            $this->from = config('laralang.default.from_lang');
        } else {
            $this->from = $from;
        }

        if (!$to) {
            $this->to = config('laralang.default.to_lang');
        } else {
            $this->to = $to;
        }


        // Checking whether from_lang or to_lang are set as language.

        if ($this->from == 'app_locale') {
            $this->from = App::getLocale();
        }

        if ($this->to == 'app_locale') {
            $this->to = App::getLocale();
        }
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    public function setTranslator($translator)
    {
        $this->translator = $translator;

        return $this;
    }

    public function run()
    {

        // Return the value if the language is the same.

        if ($this->from == $this->to) {
            if ($this->debug == true) {
                $this->translation = '<font style="color:orange;">Same in <> out languge</font>';
            }

            return;
        }


        $available_transoltors = ['apertium'];


        // Checks available translators.

        if (in_array($this->translator, $available_transoltors) == false) {
            if ($this->debug == true) {
                $this->translation = '<font style="color:red;">Not suported translator: '.$this->translator.'</font>';
            }

            return;
        }

        if ($this->translator == 'apertium') {
            return self::apertiumTrans();
        }
    }

    /**
     * Get translation from apertium API.
     */
    public function apertiumTrans()
    {
        // Check if it can be translated from online sources.

        $domain = 'api.apertium.org';

        if (gethostbyname($domain) != $domain) {
            $urlString = str_replace(' ', '%20', $this->string);
            $url = "http://$domain/json/translate?q=$urlString&langpair=$this->from%7C$this->to";
            $json = file_get_contents($url);
            $data = json_decode($json);

            // Checking response status

            if ($data->responseStatus != 200) {
                if ($this->debug == true) {
                    $this->translation = "<font style='color:red;'>Error ".$data->responseStatus.': '.$data->responseDetails.'</font>';
                }

                return;
            }

            $transObtained = $data->responseData->translatedText;

            // replacing special characters

            $toReplace = ['_' => ' '];
            foreach ($toReplace as $current => $next) {
                $transObtained = str_replace($current, $next, $transObtained);
            }

            $this->translation = ucfirst(strtolower(trim(str_replace('*', ' ', $transObtained))));


            // Checking debug setting to determinate how to output translation

            if ($this->debug == true) {
                $errors = [];
                $words = explode(' ', $transObtained);
                foreach ($words as $word) {
                    if ($word != '') {
                        if ($word[0] == '*') {
                            array_push($errors, substr($word, 1));
                        }
                    }
                }
                if (count($errors) == 0) {
                    $this->translation = "<font style='color:#00CC00;'>".$this->translation.'</font>';
                } else {
                    $errorWords = 'Unknoun words: ';
                    foreach ($errors as $error) {
                        $errorWords = $errorWords.$error.', ';
                    }

                    $this->translation = "<font style='color:orange;'>".substr($errorWords, 0, -2).'</font>';
                }
            }

            return;
        } else {
            if ($this->debug == true) {
                $this->translation = "<font style='color:red;'>Apertium host is down</font>";
            }

            return;
        }
    }

    public function __toString()
    {
        self::run();

        return $this->translation;
    }
}
