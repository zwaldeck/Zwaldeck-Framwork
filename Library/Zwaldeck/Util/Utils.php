<?php

namespace Zwaldeck\Util;

/**
 * Class Utils
 * @author Wout Schoovaerts
 * @package Zwaldeck\Util
 */
class Utils {

    public static function vardump($data) {
        print '<pre>';
            var_dump($data);
        print '</pre>';
    }
} 