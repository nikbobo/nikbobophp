<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：Application.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 17:32
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

/**
 * Class Application 应用
 */
class Application {
    private static $instances = array();
    private $error_log;

    private function __construct() { }

    /**
     * 创建应用
     * @param string $app_name 应用名称
     * @return Application 如果此应用已经创建则返回该应用，否则自动创建一个新的并保存
     */
    public static function create($app_name) {
        if (empty(self::$instances[$app_name]))
            self::$instances[$app_name] = new Application();
        return self::$instances[$app_name];
    }

    /**
     * 运行应用
     * @param bool $debug_mode DeBug 模式
     */
    public function run($debug_mode = false) {
        if (is_bool($debug_mode) && $debug_mode)
            ini_set('display_errors', 1);
        else {
            ini_set('display_errors', 0);
            if (is_dir(dirname($this->error_log))) {
                ini_set('log_errors', 1);
                ini_set('error_log', $this->error_log);
            }
        }
    }

    /**
     * 设置错误日志文件路径
     * @param string $file_path 文件路径
     * @return Application $this 返回对象本身以方便继续执行其他操作
     * @throws ApplicationException 给定错误日志文件路径不正确将抛出异常
     */
    public function setErrorLog($file_path) {
        if (is_dir(dirname($file_path))) {
            $this->error_log = $file_path;
            return $this;
        } else
            throw new ApplicationException('Error log file path', 104);
    }
} 