<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：Router.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 18:05
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

/**
 * Class Router URI 路由
 */
class Router {
    private static $instances = array();
    private $routes = array();

    private function __construct() { }

    /**
     * 创建路由
     * @param string $router_name 应用名称
     * @return Router 如果此路由已经创建则返回该路由，否则自动创建一个新的并保存
     */
    public static function create($router_name) {
        if (empty(self::$instances[$router_name]))
            self::$instances[$router_name] = new Router();
        return self::$instances[$router_name];
    }

    public function add(Application $application, $rule, $controller, $action) {

    }
} 