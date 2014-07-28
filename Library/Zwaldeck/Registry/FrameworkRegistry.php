<?php

namespace Zwaldeck\Registry;

class FrameworkRegistry extends Registry {

    private static $framewor_vars;

    public static function put($key, $value)
    {
        $stacktrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0];

        if(!isset($stacktrace["file"]) || (strpos(strtolower($stacktrace['file']), 'zwaldeck') == false)) {
            throw new \Exception("FrameworkRegistery should only be use internally");
        }

        if(!is_string($key) || trim($key) == '') {
            throw new \InvalidArgumentException('$key must be a valid string');
        }

        self::$framewor_vars[$key] = $value;
    }

    public static function set($key, $value)
    {
        self::put($key, $value);
    }

    public static function push($key, $value)
    {
        self::put($key, $value);
    }

    public static function get($key)
    {
        $stacktrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0];

        if(!isset($stacktrace["file"]) || (strpos(strtolower($stacktrace['file']), 'zwaldeck') == false)) {
            throw new \Exception("FrameworkRegistery should only be use internally");
        }

        if(!is_string($key) || trim($key) == '') {
            throw new \InvalidArgumentException('$key must be a valid string');
        }

        return self::$framewor_vars[$key];
    }

    public static function pop($key)
    {
        return self::get($key);
    }

    public static function pull($key)
    {
        return self::get($key);
    }


}