<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：WelcomeController.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-25 11:28
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

class WelcomeController {
    public function __construct() { }

    public function indexAction() {
        echo 'Hello World';
    }
}