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
    private static $instance;
    /**
     * @var Autoloader
     */
    private $autoloader;
    private $class_dir;
    private $not_match_to;
    private $routes = array();

    private function __construct() { }

    /**
     * 创建路由
     * @return Router 如果路由已经创建则返回该路由，否则自动创建一个新的并保存
     */
    public static function create() {
        if (empty(self::$instance))
            self::$instance = new Router();
        return self::$instance;
    }

    /**
     * 设置控制器路径
     * @param string $class_dir 控制器路径
     * @return Router $this 返回对象本身以方便继续执行其他操作
     * @throws ApplicationException 无效路径将抛出异常
     */
    public function setControllerClassDir($class_dir) {
        if (is_dir($class_dir)) {
            $this->class_dir = $class_dir;
            return $this;
        } else
            throw new ApplicationException('Path isn\'t a valid path', 104);
    }

    /**
     * 设置无法匹配（404 未找到）跳转到的文件路径
     * @param string $file_path 404 文件路径
     * @return Router $this 返回对象本身以方便继续执行其他操作
     * @throws ApplicationException 如果该文件不可读将抛出异常
     */
    public function setNotMatchTo($file_path) {
        if (is_readable($file_path)) {
            $this->not_match_to = $file_path;
            return $this;
        } else
            throw new ApplicationException('Path isn\'t a valid path', 104);
    }

    /**
     * 设置自动类装载器
     * @param Autoloader $autoloader
     * @return Router $this 返回对象本身以方便继续执行其他操作
     */
    public function setAutoloader(Autoloader $autoloader) {
        $this->autoloader = $autoloader;
        return $this;
    }

    /**
     * 添加单条路由规则
     * @param string $regex      路由规则（可用 {int} 替换整数（[0-9]+），{str} 替换字符串（[^/]+），{all} 替换所有（.+））
     * @param string $controller 分发到控制器
     * @param string $action     分发到行为
     * @throws ApplicationException 路由规则已存在、未设置自动装载器、未设置控制器路径将抛出异常
     */
    public function add($regex, $controller, $action) {
        if (!isset($this->routes[$regex])) {
            if (is_dir($this->class_dir)) {
                if ($this->autoloader instanceof Autoloader) {
                    $this->autoloader->register($controller . 'Controller',
                                                $this->class_dir . '/' . $controller . 'Controller.php');
                    $this->routes[str_replace(array('{int}',
                                                    '{str}',
                                                    '{all}'),
                                              array('([0-9]+)',
                                                    '([^/]+)',
                                                    '(.+)'),
                                              $regex)] =
                        array('controller' => $controller, 'action' => $action);
                } else
                    throw new ApplicationException('Autoloader class is not set', 107);
            } else
                throw new ApplicationException('Controller path is not set', 106);
        } else
            throw new ApplicationException('Router rule already exists', 105);
    }

    /**
     * 替换单条路由规则
     *
     * 该替换不会检查路由规则是否已存在，请慎用
     * @param string $regex      路由规则（可用 {int} 替换整数（[0-9]+），{str} 替换字符串（[^/]+），{all} 替换所有（.+））
     * @param string $controller 分发到控制器
     * @param string $action     分发到行为
     * @throws ApplicationException 未设置自动装载器、未设置控制器路径将抛出异常
     */
    public function replace($regex, $controller, $action) {
        if (is_dir($this->class_dir)) {
            if ($this->autoloader instanceof Autoloader) {
                $this->autoloader->replace($controller . 'Controller',
                                           $this->class_dir . '/' . $controller . 'Controller.php');
                $this->routes[str_replace(array('{int}',
                                                '{str}',
                                                '{all}'),
                                          array('([0-9]+)',
                                                '([^/]+)',
                                                '(.+)'),
                                          $regex)] =
                    array('controller' => $controller, 'action' => $action);
            } else
                throw new ApplicationException('Autoloader class is not set', 107);
        } else
            throw new ApplicationException('Controller path is not set', 106);
    }

    /**
     * 整理路由规则
     * @return Router $this 返回对象本身以方便继续执行其他操作
     */
    public function tidy() {
        $this->routes = array_reverse($this->routes);
        return $this;
    }

    public function dispatch(Response $response) {
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        foreach ($this->routes as $regex => $to) {
            if (preg_match('#^/?' . $regex . '/?$#i', $path_info, $matches)) {
                $controller_class = $to['controller'] . 'Controller';
                $action_method    = $to['action'] . 'Action';
                $parameters       = (array) $matches;
                @array_shift($parameters);
                break;
            }
        }
        if (!empty($controller_class) && !empty($action_method)) {
            try {
                $reflection = new ReflectionMethod($controller_class, $action_method);
                if (!empty($parameters) && $reflection->getNumberOfParameters() === count($parameters)) {
                    $reflection->invokeArgs(new $controller_class(), $parameters);
                } else {
                    if ($reflection->getNumberOfParameters() < 1) {
                        $reflection->invoke(new $controller_class());
                    } else {
                        $this->notMatch($response);
                    }
                }
            } catch (ReflectionException $e) {
                $this->notMatch($response);
            }
        } else {
            $this->notMatch($response);
        }
    }

    private function notMatch(Response $response) {
        if (is_readable($this->not_match_to)) {
            $response->setStatusCode(404)->respond();
            require $this->not_match_to;
        } else
            throw new ApplicationException('Not match to isn\'t set', 110);
    }
} 