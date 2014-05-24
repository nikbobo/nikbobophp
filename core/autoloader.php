<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：autoloader.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 10:47
 */

/**
 * Class ApplicationException 全局异常捕获器
 */
class ApplicationException extends Exception {
}

/**
 * Class Autoloader 自动类装载器
 */
class Autoloader {
    private $classes = array();
    private static $instance = array();

    /**
     * 注册 __autoload()
     */
    private function __construct() {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * 注册自动类装载器
     * @param string $autoload_name 自动类装载器名字
     * @return Autoloader 如果已经注册此自动类装载器则返回该自动类装载器，如果未注册自动类装载器则自动注册一个新的并保存
     */
    public static function register($autoload_name) {
        if (empty(self::$instance[$autoload_name]))
            self::$instance[$autoload_name] = new Autoloader();
        return self::$instance[$autoload_name];
    }

    /**
     * __autoload() 函数
     * @param string $class_name 尝试自动装载的类
     * @throws ApplicationException
     */
    public function loadClass($class_name) {
        $class_name = strtolower($class_name);
        if (isset($this->classes[$class_name])) {
            if (is_readable($this->classes[$class_name]))
                require $this->classes[$class_name];
            else
                throw new ApplicationException('Class file isn\'t readable', 102);
        } else
            throw new ApplicationException('Class not register', 101);
    }

    /**
     * 添加单个拟自动装载的类
     * @param string $class_name 类
     * @param string $file_path  文件全路径
     * @throws ApplicationException 类重复添加将抛出异常，请注意
     */
    public function addClass($class_name, $file_path) {
        if (!isset($this->classes[$class_name]))
            $this->classes[$class_name] = $file_path;
        else
            throw new ApplicationException('Class already register', 103);
    }

    /**
     * 添加多个拟自动装载的类
     *
     * 该添加不会检查是否类已添加，请慎用
     * 重复添加可能会导致之前添加的被覆盖
     * @param array $class_list 自动装载类列表，数组格式 array('类' => '文件全路径')
     */
    public function addClassList(array $class_list) {
        array_merge($class_list, $this->classes);
    }

    /**
     * 替换单个拟自动装载的类
     *
     * 该替换不会检查是否类已添加，请慎用
     * @param string $class_name 类
     * @param string $file_path  文件全路径
     */
    public function replaceClass($class_name, $file_path) {
        $this->classes[$class_name] = $file_path;
    }

    /**
     * 删除单个拟自动装载的类
     *
     * @param string $class_name 类
     * @throws ApplicationException 类未添加将抛出异常，请注意
     */
    public function deleteClass($class_name) {
        if (isset($this->classes[$class_name]))
            unset($this->classes[$class_name]);
        else
            throw new ApplicationException('Class not register', 101);
    }
} 