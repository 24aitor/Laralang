<?php

namespace Aitor24\Laralang;

use Aitor24\Laralang\Builder\ApertiumTrans;
use Aitor24\Laralang\Builder\Exception;
use Aitor24\Laralang\Builder\MymemoryTrans;

class Builder
{
    public static function trans($string)
    {
        $translator = config('laralang.default.translator');
        if (!in_array(config('laralang.default.translator'), ['apertium', 'mymemory'])) {
            return new Exception("<font style='color:red;'>Laralang doesn't support $translator translator. Check config</font>");
        } else {
            if (config('laralang.default.translator') == 'mymemory') {
                return new MymemoryTrans($string);
            } elseif (config('laralang.default.translator') == 'apertium') {
                return new ApertiumTrans($string);
            }
        }
    }
}
