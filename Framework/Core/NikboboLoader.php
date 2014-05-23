<?php

/**
 * User: 永强
 * Date: 2014/5/22
 * Time: 20:40
 */
defined('IN_FRAMEWORK') or exit('Access denied.'); // 载入安全检查
class NikboboLoader extends NikboboObject {
    private $application_path;
    private $framework_path;
    private $original_include_path;

    private function __construct($application_path, $framework_path) {
        $this->application_path = $application_path;
        $this->framework_path = $framework_path;
        $this->original_include_path = get_include_path();
        spl_autoload_register(array($this, 'autoload'));
    }

    public static function register($application_path, $framework_path) {
        return new self($application_path, $framework_path);
    }

    public function autoload($class) {
        if (strpos($class, 'Nikbobo') !== false) {
            $this->load($this->framework_path . '/Core/' . $class . '.php');
        } elseif (strpos($class, 'Controller') !== false) {
            if (!$this->load($this->application_path . '/Controller/' . $class . '.php')) {
                $this->load($this->framework_path . '/Controller/' . $class . '.php');
            }
        } elseif (strpos($class, 'Model') !== false) {
            if (!$this->load($this->application_path . '/Model/' . $class . '.php')) {
                $this->load($this->framework_path . '/Model/' . $class . '.php');
            }
        } elseif (strpos($class, 'Error') !== false) {
            if (!$this->load($this->application_path . '/Error/' . $class . '.php')) {
                $this->load($this->framework_path . '/Error/' . $class . '.php');
            }
        } elseif (strpos($class, 'Custom') !== false) {
            $this->load($this->application_path . '/Custom/' . $class . '.php');
        }
    }

    public function load($file) {
        if (is_readable($file)) {
            require $file;

            return true;
        } else {
            return false;
        }
    }
} 