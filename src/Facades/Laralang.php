<?php

namespace Aitor24\Laralang\Facades;

use Aitor24\Laralang\Translation;
use Illuminate\Support\Facades\Facade;

class Laralang extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */

    public static function trans($string, $from = null, $to = null) {
        return new Translation($string, $from, $to);
    }
}
