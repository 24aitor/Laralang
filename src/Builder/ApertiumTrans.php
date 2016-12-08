<?php

namespace Aitor24\Laralang\Builder;

class ApertiumTrans extends Translation
{
    /**
     * Get translation from apertium API.
     */
    public function main()
    {
        $host = 'api.apertium.org';

        // Check if host is online.
        if ($this->checkHost($host)) {
            // Host online

            $urlString = urlencode($this->string);
            $urldata = file_get_contents("http://$host/json/translate?q=$urlString&langpair=$this->from|$this->to");
            $data = json_decode($urldata, true);

            // Checking response status

            if ($data['responseStatus'] != 200) {
                if ($this->debug === true) {
                    $this->translation = "<font style='color:red;'>Error ".$data['responseStatus'].': '.$data['responseDetails'].'</font>';
                }

                return;
            }

            $transObtained = $data['responseData']['translatedText'];

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

            $this->checkSave();

            return;
        }
    }
}
