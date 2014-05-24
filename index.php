<?php
/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：index.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 10:41
 */
define('IN', true); // 框架安全检查标识符
define('DEBUG', true); // DEBUG 模式
define('ROOT', dirname(__FILE__)); // 根目录
define('LOG', ROOT . '/error_log.log'); // PHP 错误日志
define('CORE', ROOT . '/core'); // 框架核心代码目录
define('CONTROLLER', ROOT . '/controller'); // 控制器目录
define('MODEL', ROOT . '/model'); // 模块目录
define('VIEW', ROOT . '/view'); // 视图目录
define('LIB', ROOT . '/lib'); // 库目录
define('ERROR', VIEW . '/error'); // 错误页面目录
define('LAYOUT', VIEW . '/layout'); // 布局目录
require CORE . '/autoloader.php'; // 载入自动类装载器
try {
    Autoloader::create('application'); // 注册一个新的自动类装载器
    Autoloader::create('application')->register('Application', CORE . '/Application.php'); // 注册应用类
    Application::create('nikbobo')->setErrorLog(LOG)
               ->run(DEBUG); // 创建一个名称为“nikbobo”的应用，设置错误日志路径，运行（根据 DEBUG 常量确定是否以开发者模式运行）
    // Application::create('nikbobo')->run(DEBUG); // 创建一个名称为“nikbobo”的应用，运行（根据 DEBUG 常量确定是否以开发者模式运行）
    Autoloader::create('application')->register('Router', CORE . '/Router.php'); // 注册 URI 路由类
} catch (ApplicationException $e) {
    if (DEBUG)
        echo $e->getTraceAsHtml();
    else
        echo $e->getMessageAsHtml();
} catch (Exception $e) {
    echo '[' . $e->getCode() . '] ' . $e->getMessage() . '<br>';
    if (DEBUG)
        echo nl2br($e->getTraceAsString());
}