<?php

/**
 * User: 永强
 * Date: 2014/5/23
 * Time: 11:58
 */
class NikboboRouter extends NikboboObject
{
    private static $routers = array();
    private static $is_match = false;
    private static $match_controller;
    private static $match_action;
    private static $match_parameter;

    private function __construct()
    {
    }

    public static function start($index_controller = 'Welcome',
                                 $index_action = 'index')
    {
        self::add('/', $index_controller, $index_action);
    }

    public static function add($rule, $controller, $action)
    {
        $rule = strtr($rule, array('{int}' => '([0-9]+)', '{str}' => '([^/]+)', '{all}' => '(.+)'));
        $controller = ucfirst(strtolower($controller));
        $action = strtolower($action);
        self::$routers[$rule] = array('controller' => $controller, 'action' => $action);
        self::tidy();
    }

    private static function tidy()
    {
        self::$routers = array_reverse(self::$routers);
    }

    public static function dispatch($path_info)
    {
        if (empty($path_info)) {
            $path_info = '/';
        }
        self::tidy();
        foreach (self::$routers as $rule => $to) {
            if (preg_match('#^/?' . $rule . '/?$#i', $path_info, $match)) {
                self::$is_match = true;
                self::$match_controller = $match['controller'];
                self::$match_action = $match['action'];
                self::$match_parameter = $match;
                break;
            }
        }
    }

    public static function translate()
    {
        if (self::$is_match) {

        } else {

        }
    }
} 