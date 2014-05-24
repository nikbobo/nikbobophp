<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：Autoloader.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 10:47
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

/**
 * Class ApplicationException 全局异常捕获器
 */
class ApplicationException extends Exception {
    /**
     * 获取异常消息（HTML格式）
     * @return string
     */
    public function getMessageAsHtml() {
        return str_replace(array('{Code}', '{Message}'),
                           array($this->getCode(), $this->getMessage()),
            <<<'HTML'
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>Application Error</title>
<style type="text/css">
    .message {
        padding          : 10px;
        background-color : red;
        color            : white;
    }
    .trace {
        padding          : 10px;
        background-color : yellow;
        color            : black;
    }
</style>
</head>
<body>
<h1>Application Error</h1>
<p class="message">
    [{Code}] {Message}
</p>
</body>
</html>
HTML
        );
    }

    /**
     * 获取跟踪报告（HTML 格式）
     * @return string
     */
    public function getTraceAsHtml() {
        return str_replace(array('{Code}', '{Message}', '{Trace}'),
                           array($this->getCode(), $this->getMessage(), nl2br($this->getTraceAsString())),
            <<<'HTML'
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>Application Error</title>
<style type="text/css">
    .message {
        padding          : 10px;
        background-color : red;
        color            : white;
    }
    .trace {
        padding          : 10px;
        background-color : yellow;
        color            : black;
    }
</style>
</head>
<body>
<h1>Application Error</h1>
<p class="message">
    [{Code}] {Message}
</p>
<h2>PHP Debug</h2>
<p class="trace">
    {Trace}
</p>
</body>
</html>
HTML
        );
    }
}

/**
 * Class Autoloader 自动类装载器
 */
class Autoloader {
    private static $instances = array();
    private $classes = array();

    /**
     * 注册 __autoload()
     */
    private function __construct() {
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * 创建自动类装载器
     * @param string $autoload_name 自动类装载器名字
     * @return Autoloader 如果此自动类装载器已经创建则返回该自动类装载器，否则自动创建一个新的并保存
     */
    public static function create($autoload_name) {
        if (empty(self::$instances[$autoload_name]))
            self::$instances[$autoload_name] = new Autoloader();
        return self::$instances[$autoload_name];
    }

    /**
     * __autoload() 函数
     * @param string $class_name 尝试自动装载的类
     * @throws ApplicationException 类无法自动装载将抛出异常（类未注册，类对应文件不可读）
     */
    public function load($class_name) {
        if (isset($this->classes[$class_name])) {
            if (is_readable($this->classes[$class_name]))
                require $this->classes[$class_name];
            else
                throw new ApplicationException('Class file isn\'t readable', 102);
        } else
            throw new ApplicationException('Class not register', 101);
    }

    /**
     * 注册单个拟自动装载的类
     * @param string $class_name 类
     * @param string $file_path  文件全路径
     * @throws ApplicationException 类重复注册将抛出异常
     */
    public function register($class_name, $file_path) {
        if (!isset($this->classes[$class_name]))
            $this->classes[$class_name] = $file_path;
        else
            throw new ApplicationException('Class already register', 103);
    }

    /**
     * 注册多个拟自动装载的类
     *
     * 该注册不会检查是否重复注册，请慎用
     * 重复注册可能会导致之前的被覆盖
     * @param array $class_list 自动装载类列表，数组格式 array('类' => '文件全路径')
     */
    public function registers(array $class_list) {
        array_merge($class_list, $this->classes);
    }

    /**
     * 替换单个拟自动装载的类
     *
     * 该替换不会检查是否类已注册，请慎用
     * @param string $class_name 类
     * @param string $file_path  文件全路径
     */
    public function replace($class_name, $file_path) {
        $this->classes[$class_name] = $file_path;
    }

    /**
     * 检查指定类是否已经注册
     * @param string $class_name 类
     * @return bool 已注册返回 True，未注册返回 False
     */
    public function isRegister($class_name) {
        if (isset($this->classes[$class_name]))
            return true;
        else
            return false;
    }

    /**
     * 反注册单个拟自动装载的类
     *
     * @param string $class_name 类
     * @throws ApplicationException 类未添加将抛出异常
     */
    public function unRegister($class_name) {
        if (isset($this->classes[$class_name]))
            unset($this->classes[$class_name]);
        else
            throw new ApplicationException('Class not register', 101);
    }
} 