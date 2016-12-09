<?php

namespace Aitor24\Laralang\Builder;

use Aitor24\Laralang\Models\DB_Translation;
use App;

class Translation
{
    /**
     * Setup public vars.
     */
    public $translation;
    public $translator;
    public $string;
    public $debug;
    public $from;
    public $to;
    public $save;

    /**
     * Setup default values.
     *
     * @param string $string
     */
    public function __construct($string)
    {
        $this->translator = config('laralang.default.translator');
        $this->debug = config('laralang.default.debug');
        $this->save = config('laralang.default.autosave');
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
    public function debug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Setup fromLang value.
     *
     * @param string $lang
     */
    public function from($lang)
    {
        $this->from = $lang;

        return $this;
    }

    /**
     * Setup tolang value.
     *
     * @param string $lang
     */
    public function to($lang)
    {
        $this->to = $lang;

        return $this;
    }

    /**
     * Setup translator.
     *
     * @param string $translator
     */
    public function translator($translator)
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * Setup save option.
     *
     * @param bool $save
     */
    public function Save($save)
    {
        $this->save = $save;

        return $this;
    }

    public function loadIfExists()
    {
        $existing = DB_Translation::where('string', '=', $this->string)
        ->where('from_lang', '=', $this->from)
        ->where('to_lang', '=', $this->to)
        ->where('translator', '=', $this->translator)->get();

        if (count($existing) == 0) {
            return false;
        }
        if ($this->debug === true) {
            $this->translation = "<font style='color:#00CC00;'>Translation loaded from DB</font>";
        } else {
            $this->translation = ($existing[0]->translation);
        }

        return true;
    }

    /**
     * Function to save translations to DB.
     */
    public function checkSave()
    {
        if ($this->save === true) {
            $trans = new DB_Translation();
            $trans->string = $this->string;
            $trans->from_lang = $this->from;
            $trans->to_lang = $this->to;
            $trans->translator = $this->translator;
            $trans->translation = $this->translation;
            $trans->save();

            // Checking debug setting to determinate how to output translation

            if ($this->debug === true) {
                $this->translation = "<font style='color:#00CC00;'> Translation saved on DB </font>";
            }
        } else {
            if ($this->debug === true) {
                $this->translation = "<font style='color:orange;'> Translation not saved on DB </font>";
            }
        }
    }

    /**
     * This fuction is called to know the status of host, and it would set translation if debug is true.
     *
     * @param string $host
     */
    public function checkHost($host)
    {
        $socket = @fsockopen($host, 80, $errno, $errstr, 30);

        if ($socket) {
            return true;
            fclose($socket);
        } else {
            if ($this->debug === true) {
                $this->translation = "<font style='color:red;'>$this->translator host is down! </font>";
            }
        }
    }

    /**
     * This fuction is called by trans() function of Fadade Laralang
     * It would call run() function of this class and returns the translation.
     */
    public function __toString()
    {
        if ($this->from == $this->to) {
            if ($this->debug) {
                return "<font style='color:orange;'>Same in <> out language</font>";
            }

            return $this->string;
        } elseif (!$this->loadIfExists()) {
            $this->main();
        }

        return $this->translation;
    }
}
