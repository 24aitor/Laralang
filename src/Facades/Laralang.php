<?php

namespace Aitor24\Laralang\Facades;

use Illuminate\Support\Facades\Facade;
use Aitor24\Laralang\Builder;

class Laralang extends Facade
{
    /**
     * Get the trnaslation.
     *
     * @param string $string
     *
     * @return string method of object
     */
    public static function getFacadeAccessor()
    {
        return Builder::class;
    }
}
