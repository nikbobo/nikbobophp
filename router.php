<?php
/**
 * Project: Nikbobo PHP Framework
 * File: router.php
 * User: nikbobo
 * Date: 14-3-17
 * Time: 下午12:22
 */
/**
 * 路由配置文件
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');

return array('/' => array('Controller' => NP_DEFAULT_CONTROLLER, 'Action' => NP_DEFAULT_ACTION));