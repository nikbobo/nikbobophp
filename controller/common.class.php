<?php
/**
 * Project: Nikbobo PHP Framework
 * File: common.class.php
 * User: nikbobo
 * Date: 2014-03-21
 * Time: 16:17
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');

/**
 * 载入框架基础前端控制器
 */
require NP_FRAMEWORK_DIR . '/controller/controller.class.php';

/**
 * Class CommonController 应用公共前端控制器
 */
class CommonController extends Controller {
    /**
     * 预载方法，目前主要作用为调用父类的预载方法
     */
    function __construct() {
        /**
         * 调用父类的预载方法
         */
        parent::__construct();
    }
} 