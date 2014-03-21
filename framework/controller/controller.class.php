<?php
/**
 * Project: Nikbobo PHP Framework
 * File: controller.class.php
 * User: nikbobo
 * Date: 2014-03-20
 * Time: 22:00
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');

/**
 * Class Controller 框架基础前端控制器
 */
class Controller {
    /**
     * 预载方法，目前作用主要为载入 Model Function
     */
    function __construct() {
        $sModelFile = NP_APP_DIR . '/model/function.' . basename(strtolower(_server('NP_CONTROLLER'))) . '.php';
        if (file_exists($sModelFile)) {
            require $sModelFile;
        } else {
            $sModelFile = NP_FRAMEWORK_DIR . '/model/function.' . basename(strtolower(_server('NP_CONTROLLER'))) . '.php';
            if (file_exists($sModelFile)) {
                require $sModelFile;
            }
        }
    }
}