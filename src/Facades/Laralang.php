<?php

namespace Aitor24\Laralang\Facades;

use Illuminate\Support\Facades\Facade;
use Aitor24\Laralang\Builder;

class Laralang extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Builder::class;
    }
}
