<?php
/**
 * Project: Nikbobo PHP Framework
 * File: index.php
 * User: nikbobo
 * Date: 14-3-14
 * Time: 下午6:41
 */
/**
 * 调试模式
 *
 * 如需关闭调试模式请更改为假（false）
 * 默认值为真（true）
 */
define('NP_DEBUG', true);
/**
 * 错误日志
 *
 * 默认值为本文件所在目录的 debug.log
 */
define('NP_DEBUG_LOG', dirname(__FILE__) . '/debug.log');
/**
 * 应用根目录
 *
 * 默认值为本文件所在目录
 */
define('NP_APP_DIR', dirname(__FILE__));
/**
 * 框架根目录
 *
 * 默认值为应用根目录下的框架（Framework）目录
 * 可不定义，在引入框架入口文件之后会自动定义框架根目录
 */
define('NP_FRAMEWORK_DIR', NP_APP_DIR . '/framework');
/**
 * 配置文件目录
 *
 * 默认值为应用根目录下的配置（Config）目录
 */
define('NP_CONFIG_FILE', NP_APP_DIR . '/config.php');
/**
 * 入口检测
 *
 * 使用 defined('IN_NP') 进行入口检测所用，不可注释，不可更改为假（false）或其他值，否则后果自负
 */
define('IN_NP', true);
/**
 * 载入框架
 */
require NP_FRAMEWORK_DIR . '/index.php';