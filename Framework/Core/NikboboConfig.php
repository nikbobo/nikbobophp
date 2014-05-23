<?php

/**
 * User: 永强
 * Date: 2014/5/22
 * Time: 20:15
 */
class NikboboConfig extends NikboboObject {
    private static $_config = array();

    private function __construct() {
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @param bool   $check_empty
     * @return mixed
     */
    public static function get($key, $default = false, $check_empty = false) {
        if ($check_empty) {
            return empty(self::$_config[$key]) ? self::$_config[$key] : $default;
        } else {
            return isset(self::$_config[$key]) ? self::$_config[$key] : $default;
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param bool   $replace
     * @return bool
     */
    public static function set($key, $value, $replace = false) {
        if ($replace || !self::get($key)) {
            self::$_config[$key] = $value;

            return true;
        } else {
            return false;
        }
    }
} 