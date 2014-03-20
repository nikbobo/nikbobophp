<?php
/**
 * Project: Nikbobo PHP Framework
 * File: index.php
 * User: nikbobo
 * Date: 14-3-14
 * Time: 下午8:47
 */
/**
 * 框架入口文件
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * 检测是否存在应用根目录
 */
defined('NP_APP_DIR') or exit('Not Found Application');
/**
 * 如果未定义框架根目录，定义框架根目录为本文件所在目录
 */
defined('NP_FRAMEWORK_DIR') or define('NP_FRAMEWORK_DIR', dirname(__FILE__));
/**
 * 载入配置文件
 */
(defined('NP_CONFIG_FILE') and file_exists(NP_CONFIG_FILE)) ? require NP_CONFIG_FILE : exit('Not Found Configure');
/**
 * 开启 Session 就启动 Session
 */
(defined('NP_SESSION_AUTO_START') and NP_SESSION_AUTO_START) and session_start();
/**
 * 配置时区
 */
(defined(NP_TIMEZONE) and NP_TIMEZONE) and date_default_timezone_set(NP_TIMEZONE);
/**
 * 取消自动注册全局变量（register_globals），清理系统环境
 */
function _unregister_globals() {
    if (!ini_get('register_globals')) {
        return;
    }

    if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) {
        exit('GLOBALS Overwrite Attempt Detected');
    }

    // 不能被清理的超全局变量
    $aNoUnset = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');

    $aInput = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());

    foreach ($aInput as $sKey => $sValue) {
        if (!in_array($sKey, $aNoUnset) && isset($GLOBALS[$sKey])) {
            unset($GLOBALS[$sKey]);
        }
    }
}

/**
 * 取消自动注册全局变量（register_globals），清理系统环境
 */
_unregister_globals();

/**
 * 关闭魔术引号（Magic Quotes）
 */
if (function_exists('get_magic_quotes_gpc')) {
    if (get_magic_quotes_gpc()) {
        /**
         * 关闭指定值（Value）的魔术引号（Magic Quotes）
         *
         * @param string $saValue 需要关闭魔术引号（Magic Quotes）的值（Value）
         *
         * @return array|string 处理好的数组（Array）或字符串（String）
         */
        function _stripslashes_deep($saValue) {
            $saValue = is_array($saValue) ? array_map('_stripslashes_deep', $saValue) : stripslashes($saValue);

            return $saValue;
        }

        $_POST = array_map('_stripslashes_deep', $_POST);
        $_GET = array_map('_stripslashes_deep', $_GET);
        $_COOKIE = array_map('_stripslashes_deep', $_COOKIE);
        $_REQUEST = array_map('_stripslashes_deep', $_REQUEST);
    }
}
/**
 * 定义调试模式默认值为真（true）
 */
defined('NP_DEBUG') or define('NP_DEBUG', true);
/**
 * 报告所有错误
 */
error_reporting(E_ALL);
if (NP_DEBUG) {
    /**
     * 开启调试模式，显示错误信息
     */
    ini_set('display_errors', 1);

} else {
    /**
     * 关闭调试模式，不显示错误信息，记录错误
     */
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', NP_DEBUG_LOG);
}
/**
 * 载入基础函数
 */
require NP_FRAMEWORK_DIR . '/library/function.base.php';
if (file_exists(NP_APP_DIR . 'library/function.base.php')) {
    /**
     * 载入用户定义的基础函数
     */
    require NP_APP_DIR . 'library/function.base.php';
}
/**
 * 载入数据库函数
 */
if (defined('NP_USE_DATABASE') && NP_USE_DATABASE) {
    $sDatabaseFunctionPath = NP_APP_DIR . '/library/function.db.' . strtolower(NP_DATABASE_TYPE) . '.php';
    if (file_exists($sDatabaseFunctionPath)) {
        require $sDatabaseFunctionPath;
    } else {
        $sDatabaseFunctionPath = NP_FRAMEWORK_DIR . '/library/function.db.' . strtolower(NP_DATABASE_TYPE) . '.php';
        file_exists($sDatabaseFunctionPath) and require $sDatabaseFunctionPath;
    }
}
// todo 在此载入数据库和缓存函数 function.extra.php
/**
 * 路由分发
 */
/**
 * 载入路由配置文件
 */
(defined('NP_ROUTER_CONFIG_FILE') and file_exists(NP_ROUTER_CONFIG_FILE)) ? $aRouterRule = is_array(require NP_ROUTER_CONFIG_FILE) ? array_reverse(require NP_ROUTER_CONFIG_FILE) : exit('Router Configure Must Is Array') : exit('Not Found Router Configure');
/**
 * 开始分发路由
 */
/**
 * 获取 PATH_INFO
 */
isset($_SERVER['PATH_INFO']) ? $sPathInfo = $_SERVER['PATH_INFO'] : $sPathInfo = '/';
/**
 * 确定要转换的路由参数
 */
$aTypeToRegex = array('{int}' => '([0-9]+)', '{str}' => '([^/]+)', '{all}' => '(.+)');
/**
 * 初始化 URL 参数数组
 */
$aParameter = array();
/**
 * 初始化正则路由匹配检查
 */
$bRouterMatch = false;
/**
 * PCRE 正则匹配路由规则和参数
 */
foreach ($aRouterRule as $sPath => $aTo) {
    $sPath = strtr($sPath, $aTypeToRegex);
    if (preg_match('#^/?' . $sPath . '/?$#i', $sPathInfo, $aMatch)) {
        $bRouterMatch = true;
        $sController = $aTo['Controller'];
        $sAction = $aTo['Action'];
        $aParameter = $aMatch;
        @array_shift($aParameter);
        break;
    }
}
/**
 * 找不到对应的路由规则，按照默认规则分配
 *
 * 默认规则：http://www.domain.com/controller/action/parameter1/.../parameter(n)
 */
if (defined('NP_ROUTER_DEFAULT') && NP_ROUTER_DEFAULT && !$bRouterMatch) {
    $aUrlSegment = explode('/', $sPathInfo);
    $aUrlSegment = array_slice(array_filter($aUrlSegment, 'strlen'), 0);
    $sController = array_shift($aUrlSegment);
    $sAction = array_shift($aUrlSegment);
    $aParameter = $aUrlSegment;
}
if (empty($sController)) {
    if ($sPathInfo === '/') {
        $sController = NP_DEFAULT_CONTROLLER;
    } else {
        trigger_error('need controller.', E_USER_WARNING);
        _exit('404 Not Found', '抱歉，找不到该页，请确认您输入的 URL 是否正确。', 404);
    }
}
$sController = !empty($sController) ? $sController : NP_DEFAULT_CONTROLLER;
$sAction = !empty($sAction) ? $sAction : NP_DEFAULT_ACTION;
$sController = $_SERVER['NP_CONTROLLER'] = ucfirst(basename(strtolower(strip_tags($sController))));
$sAction = $_SERVER['NP_ACTION'] = ucfirst(basename(strtolower(strip_tags($sAction))));
$sControllerClass = $sController . 'Controller';
$sActionMethod = $sAction . 'Action';
$sControllerFile = basename(strtolower($sController)) . '.class.php';
$sControllerPath = NP_APP_DIR . '/controller/' . $sControllerFile;
/**
 * 载入包含该控制器的文件，自动在应用控制器目录和框架控制器目录中查找
 */
if (!file_exists($sControllerPath)) {
    $sControllerPath = NP_FRAMEWORK_DIR . '/controller/' . $sControllerFile;
    if (!file_exists($sControllerPath)) {
        trigger_error('controller file ' . $sControllerFile . ' isn\'t found.', E_USER_WARNING);
        _exit('404 Not Found', '抱歉，找不到该页，请确认您输入的 URL 是否正确。', 404);
    }
}
require $sControllerPath;
/**
 * 使用 PHP 反射分发路由
 */
try {
    $oReflection = new ReflectionMethod($sControllerClass, $sActionMethod);
    if ($oReflection->getNumberOfParameters() === count($aParameter)) {
        $oReflection->invokeArgs(new $sControllerClass(), $aParameter);
    } else {
        if ($oReflection->getNumberOfParameters() < 1) {
            $oReflection->invoke(new $sControllerClass());
        } else {
            trigger_error($sControllerClass . '::' . $sActionMethod . '() need parameter(s).', E_USER_WARNING);
            _exit('404 Not Found', '抱歉，找不到该页，请确认您输入的 URL 是否正确。', 404);
        }
    }
} catch (ReflectionException $e) {
    trigger_error($e->getMessage(), E_USER_WARNING);
    _exit('404 Not Found', '抱歉，找不到该页，请确认您输入的 URL 是否正确。', 404);
}


