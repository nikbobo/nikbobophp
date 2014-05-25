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
define('CHARSET', 'UTF-8'); // 全局页面编码
require CORE . '/Autoloader.php'; // 载入自动类装载器
require CORE . '/ApplicationException.php'; // 载入全局异常处理器
try {
    Autoloader::create('core'); // 注册一个新的自动类装载器
    Autoloader::create('core')->register('Application', CORE . '/Application.php'); // 注册应用类
    Application::create()->setSessionStart(false)->setErrorLog(LOG)
               ->run(DEBUG); // 创建应用，不自动启动 Session，设置错误日志路径，运行（根据 DEBUG 常量确定是否以开发者模式运行）
    // Application::create('app')->setSessionStart(false)->run(DEBUG); // 创建一个应用，不自动启动 Session，运行（根据 DEBUG 常量确定是否以开发者模式运行）
    Autoloader::create('core')->register('Response', CORE . '/Response.php'); // 注册 Header 处理类
    Autoloader::create('core')->register('Router', CORE . '/Router.php'); // 注册 URI 路由类
    Router::create()->setAutoloader(Autoloader::create('controller'))
          ->setControllerClassDir(CONTROLLER)->setNotMatchTo(ERROR . '/404.php')
          ->add('/', 'Welcome', 'index'); // 创建路由，设置为一个新的自动装载器，设置控制器路径，设置 404 页面路径，并添加首页路由规则
    // 在此处添加路由规则，或者 require 一个文件专门定义路由规则
    Router::create()->tidy()->dispatch(Response::create()); // 分发路由
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