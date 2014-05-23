<?php
/**
 * User: 永强
 * Date: 2014/5/23
 * Time: 9:55
 */
defined('APPLICATION_PATH') or exit('Not found application.'); // 没有应用，单纯载入框架怎么行？
defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH', dirname(__FILE__)); // 定义框架根目录
defined('IN_FRAMEWORK') or define('IN_FRAMEWORK', true); // 定义框架安全检查标识符
require FRAMEWORK_PATH . '/Core/NikboboLoader.php'; // 导入自动加载类文件
NikboboLoader::register(APPLICATION_PATH, FRAMEWORK_PATH); // 注册自动加载类
NikboboRouter::set('Default', 'index');
NikboboRouter::add('/', 'aa', 'bb');
NikboboRouter::add('/aaa', 'cc', 'ddd');
NikboboRouter::add('/aa/{int}', 'ewe', 'ss');
NikboboRouter::get();