<?php

namespace Zwaldeck\Util;

/**
 * Class Utils
 * @author Wout Schoovaerts
 * @package Zwaldeck\Util
 */
class Utils {

    /**
     * @param string $data
     */
    public static function vardump($data) {
        print '<pre>';
            var_dump($data);
        print '</pre>';
    }

    /**
     * starts the haystack with needle?
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    /**
     * ends the haystack with needle?
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
} 