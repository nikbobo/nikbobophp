<?php

/**
 * User: 永强
 * Date: 2014/5/23
 * Time: 11:58
 */
class NikboboRouter extends NikboboObject {
    private static $routers = array();
    private static $default_controller = 'default';
    private static $default_action = 'index';

    private function __construct() {
    }

    public static function set($default_controller = 'Default',
                               $default_action = 'index') {
        self::$default_controller = $default_controller;
        self::$default_action = $default_action;
        self::add('/', $default_controller, $default_action);
    }

    public static function add($rule, $controller, $action) {
        $rule = strtr($rule, array('{int}' => '([0-9]+)', '{str}' => '([^/]+)', '{all}' => '(.+)'));
        $controller = ucfirst($controller);
        $action = strtolower($action);
        self::$routers[] = array('rule' => $rule, 'controller' => $controller, 'action' => $action);
    }

    public static function get() {
        var_dump(self::$routers);
    }
} 