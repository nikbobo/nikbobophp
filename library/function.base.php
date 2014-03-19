<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.base.php
 * User: nikbobo
 * Date: 2014-03-19
 * Time: 18:14
 */
/**
 * 由用户定义的在框架启动之初就载入的函数
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * 输出站点根 URL
 */
function my_base_url() {
    echo BASE_URL;
}

/**
 * 输出站点名称
 */
function my_site_name() {
    echo SITE_NAME;
}