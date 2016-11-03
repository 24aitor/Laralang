<?php

namespace Aitor24\Laralang\Facades;

use Aitor24\Laralang\Translation;
use Illuminate\Support\Facades\Facade;

class Laralang extends Facade
{
    /**
     * Get the trnaslation.
     *
     * @param string $string
     *
     * @return string method of object
     */
    public static function trans($string)
    {
        return new Translation($string);
    }
}
