<?php
/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：index.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 10:41
 */
define('IN', true); // 框架安全检查标识符
define('ROOT', dirname(__FILE__)); // 根目录
define('CORE', ROOT . '/core'); // 框架核心代码目录
define('CONTROLLER', ROOT . '/controller'); // 控制器目录
define('MODEL', ROOT . '/model'); // 模块目录
define('VIEW', ROOT . '/view'); // 视图目录
define('LIB', ROOT . '/lib'); // 库目录
define('ERROR', VIEW . '/error'); // 错误页面目录
define('LAYOUT', VIEW . '/layout'); // 布局目录
require CORE . '/Autoloader.php'; // 载入自动类装载器
Autoloader::register('application'); // 注册一个新的自动类装载器