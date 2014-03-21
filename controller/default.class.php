<?php
/**
 * Project: Nikbobo PHP Framework
 * File: default.class.php
 * User: nikbobo
 * Date: 2014-03-21
 * Time: 18:17
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');

/**
 * 载入应用公共前端控制器
 */
require NP_APP_DIR . '/controller/common.class.php';

/**
 * Class DefaultController 默认控制器
 *
 * 主要的作用是做一个示范
 */
class DefaultController extends CommonController {
    /**
     * 预载方法，目前主要作用为调用父类的预载方法
     */
    function __construct() {
        /**
         * 调用父类的预载方法
         */
        parent::__construct();
    }

    /**
     * 欢迎页面
     */
    public function IndexAction() {
        $data = array('top_title' => '欢迎', 'title' => '欢迎使用');
        _view('welcome', $data);
    }
} 