<?php
/**
 * Project: Nikbobo PHP Framework
 * File: function.base.php
 * User: nikbobo
 * Date: 14-3-14
 * Time: 下午9:24
 */
/**
 * 入口检测，阻止非法访问
 */
defined('IN_NP') or exit('Access Denied');
/**
 * 在框架启动之初就载入的函数
 */
/**
 * 获取 $_GET 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @param string $sKey    键（Key）
 * @param string $sFilter 过滤器，可选 isset（PHP isset 函数）和 empty（PHP empty 函数），默认为 isset
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _get($sKey, $sFilter = 'isset') {
    switch ($sFilter) {
        case 'isset':
            return isset($_GET[$sKey]) ? $_GET[$sKey] : false;
        case 'empty':
            return empty($_GET[$sKey]) ? $_GET[$sKey] : false;
        default:
            return isset($_GET[$sKey]) ? $_GET[$sKey] : false;
    }
}

/**
 * 获取 $_POST 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @param string $sKey    键（Key）
 * @param string $sFilter 过滤器，可选 isset（PHP isset 函数）和 empty（PHP empty 函数），默认为 isset
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _post($sKey, $sFilter = 'isset') {
    switch ($sFilter) {
        case 'isset':
            return isset($_POST[$sKey]) ? $_POST[$sKey] : false;
        case 'empty':
            return empty($_POST[$sKey]) ? $_POST[$sKey] : false;
        default:
            return isset($_POST[$sKey]) ? $_POST[$sKey] : false;
    }
}

/**
 * 获取 $_REQUEST 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @deprecated
 *
 * @param string $sKey    键（Key）
 * @param string $sFilter 过滤器，可选 isset（PHP isset 函数）和 empty（PHP empty 函数），默认为 isset
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _request($sKey, $sFilter = 'isset') {
    _deprecated('_request()', '_get() or _post()');
    switch ($sFilter) {
        case 'isset':
            return isset($_REQUEST[$sKey]) ? $_REQUEST[$sKey] : false;
        case 'empty':
            return empty($_REQUEST[$sKey]) ? $_REQUEST[$sKey] : false;
        default:
            return isset($_REQUEST[$sKey]) ? $_REQUEST[$sKey] : false;
    }
}

/**
 * 获取 $_SERVER 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @param string $sKey    键（Key）
 * @param string $sFilter 过滤器，可选 isset（PHP isset 函数）和 empty（PHP empty 函数），默认为 isset
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _server($sKey, $sFilter = 'isset') {
    switch ($sFilter) {
        case 'isset':
            return isset($_SERVER[$sKey]) ? $_SERVER[$sKey] : false;
        case 'empty':
            return empty($_SERVER[$sKey]) ? $_SERVER[$sKey] : false;
        default:
            return isset($_SERVER[$sKey]) ? $_SERVER[$sKey] : false;
    }
}

/**
 * 获取 $_SESSION 指定键（Key）的值（Value），不会导致 PHP Warning
 *
 * @param string $sKey    键（Key）
 * @param string $sFilter 过滤器，可选 isset（PHP isset 函数）和 empty（PHP empty 函数），默认为 isset
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _session($sKey, $sFilter = 'isset') {
    switch ($sFilter) {
        case 'isset':
            return isset($_SESSION[$sKey]) ? $_SESSION[$sKey] : false;
        case 'empty':
            return empty($_SESSION[$sKey]) ? $_SESSION[$sKey] : false;
        default:
            return isset($_SESSION[$sKey]) ? $_SESSION[$sKey] : false;
    }
}

/**
 * 提示函数即将废止（Deprecated），使用 PHP 原生提示方式
 *
 * @param string $sDeprecated 即将废止的函数
 * @param string $sInstead    替代的函数
 */
function _deprecated($sDeprecated, $sInstead) {
    trigger_error($sDeprecated . ' is deprecated, use ' . $sInstead . 'instead it.', E_USER_DEPRECATED);
}

/**
 * PHP echo 增强版
 *
 * 输出提示信息，包含永不过期的头部信息
 *
 * @param string $sMessage 提示信息
 */
function _echo($sMessage) {
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=' . SITE_CHARSET);
        _nocache_header();
    }
    echo $sMessage;
}

/**
 * 输出指定 HTTP 状态码的头部信息
 *
 * @param int $iHttpStatusCode HTTP 状态码
 */
function _status_code_header($iHttpStatusCode) {
    $aHttpStatus = array(100 => 'Continue',
                         101 => 'Switching Protocols',
                         102 => 'Processing',
                         200 => 'OK',
                         201 => 'Created',
                         202 => 'Accepted',
                         203 => 'Non-Authoritative Information',
                         204 => 'No Content',
                         205 => 'Reset Content',
                         206 => 'Partial Content',
                         207 => 'Multi-Status',
                         226 => 'IM Used',
                         300 => 'Multiple Choices',
                         301 => 'Moved Permanently',
                         302 => 'Found',
                         303 => 'See Other',
                         304 => 'Not Modified',
                         305 => 'Use Proxy',
                         306 => 'Reserved',
                         307 => 'Temporary Redirect',
                         400 => 'Bad Request',
                         401 => 'Unauthorized',
                         402 => 'Payment Required',
                         403 => 'Forbidden',
                         404 => 'Not Found',
                         405 => 'Method Not Allowed',
                         406 => 'Not Acceptable',
                         407 => 'Proxy Authentication Required',
                         408 => 'Request Timeout',
                         409 => 'Conflict',
                         410 => 'Gone',
                         411 => 'Length Required',
                         412 => 'Precondition Failed',
                         413 => 'Request Entity Too Large',
                         414 => 'Request-URI Too Long',
                         415 => 'Unsupported Media Type',
                         416 => 'Requested Range Not Satisfiable',
                         417 => 'Expectation Failed',
                         422 => 'Unprocessable Entity',
                         423 => 'Locked',
                         424 => 'Failed Dependency',
                         426 => 'Upgrade Required',
                         500 => 'Internal Server Error',
                         501 => 'Not Implemented',
                         502 => 'Bad Gateway',
                         503 => 'Service Unavailable',
                         504 => 'Gateway Timeout',
                         505 => 'HTTP Version Not Supported',
                         506 => 'Variant Also Negotiates',
                         507 => 'Insufficient Storage',
                         510 => 'Not Extended');
    if (isset($aHttpStatus[$iHttpStatusCode]) && !headers_sent()) {
        header('HTTP/1.1 ' . $iHttpStatusCode . ' ' . $aHttpStatus[$iHttpStatusCode]);
        header('Status: ' . $iHttpStatusCode . ' ' . $aHttpStatus[$iHttpStatusCode]);
    }
}

/**
 * 输出永不过期、不被浏览器缓存的头部信息
 */
function _nocache_header() {
    if (!headers_sent()) {
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        @header_remove('Last-Modified');
    }
}

/**
 * 载入模板
 *
 * @param string $sTemplate 模板名称
 * @param array  $aData     模板中可供调用的变量，以数组键值对（Key => Value）形式撰写，经过处理后，数组键（Key）作为变量名，数组键（Value）作为变量的值
 * @param string $sGroup    模板组
 */
function _view($sTemplate = 'default', array $aData = array(), $sGroup = 'web') {
    $_SERVER['NP_TEMPLATE'] = $sTemplate;
    $_SERVER['NP_TEMPLATE_GROUP'] = $sGroup;
    $sTemplatePath = NP_APP_DIR . '/view/' . $sGroup . '/' . $sTemplate . '.tpl.php';
    if (file_exists($sTemplatePath)) {
        is_array($aData) and extract($aData);
        require $sTemplatePath;
    } else {
        $sTemplatePath = NP_FRAMEWORK_DIR . '/view/' . $sGroup . '/' . $sTemplate . '.tpl.php';
        if (file_exists($sTemplatePath)) {
            is_array($aData) and extract($aData);
            require $sTemplatePath;
        }
    }
}

/**
 * 载入模板，并将 HTML 返回
 *
 * @param string $sTemplate 模板名称
 * @param array  $aData     模板中可供调用的变量，以数组键值对（Key => Value）形式撰写，经过处理后，数组键（Key）作为变量名，数组键（Value）作为变量的值
 * @param string $sGroup    模板组
 *
 * @return string 返回处理好的 HTML 内容
 */
function _view_raw($sTemplate = 'default', array $aData = array(), $sGroup = 'web') {
    ob_start();
    _view($sTemplate, $aData, $sGroup);
    $sContent = ob_get_contents();
    ob_end_clean();
    return $sContent;
}

/**
 * PHP exit 增强版
 *
 * 输出一个消息并且退出当前脚本，包含特定状态码和永不过期的头部信息
 *
 * @param   string $sTopTitle       页面标题
 * @param string   $sTitle          提示信息标题
 * @param string   $sMessage        提示信息
 * @param int      $iHttpStatusCode HTTP 状态码
 */
function _exit($sTopTitle, $sTitle, $sMessage, $iHttpStatusCode = 200) {
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=' . SITE_CHARSET);
        _status_code_header($iHttpStatusCode);
        _nocache_header();
    }
    $data = array('top_title' => $sTopTitle, 'title' => $sTitle, 'message' => $sMessage);
    _view('info', $data);
    exit;
}