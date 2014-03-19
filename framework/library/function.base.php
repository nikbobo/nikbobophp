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
 * @param string $sKey
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _get($sKey) {
    return isset($_GET[$sKey]) ? $_GET[$sKey] : false;
}

/**
 * 获取 $_POST 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @param string $sKey
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _post($sKey) {
    return isset($_POST[$sKey]) ? $_POST[$sKey] : false;
}

/**
 * 获取 $_REQUEST 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @deprecated
 *
 * @param string $sKey
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _request($sKey) {
    _deprecated('_request()', '_get() or _post()');

    return isset($_REQUEST[$sKey]) ? $_REQUEST[$sKey] : false;
}

/**
 * 获取 $_SERVER 指定键（Key）的值（Value），不会导致 PHP Warrning
 *
 * @param string $sKey
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _server($sKey) {
    return isset($_SERVER[$sKey]) ? $_SERVER[$sKey] : false;
}

/**
 * 获取 $_SESSION 指定键（Key）的值（Value），不会导致 PHP Warning
 *
 * @param string $sKey
 *
 * @return mixed 如果存在该键（Key），返回对应的值（Value），不存在，返回假（false）
 */
function _session($sKey) {
    return isset($_SESSION[$sKey]) ? $_SESSION[$sKey] : false;
}

/**
 * 提示函数即将废止（Deprecated），使用 PHP 原生提示方式
 *
 * @param string $sDeprecated 即将废止的函数
 * @param string $sInstead 替代的函数
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
 * PHP exit 增强版
 *
 * 输出一个消息并且退出当前脚本，包含特定状态码和永不过期的头部信息
 *
 * @param string $sTitle 页面标题
 * @param string $sMessage 提示信息
 * @param int $iHttpStatusCode HTTP 状态码
 */
function _exit($sTitle, $sMessage, $iHttpStatusCode = 200) {
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=' . SITE_CHARSET);
        _status_code_header($iHttpStatusCode);
        _nocache_header();
    }
    ?>
    <!DOCTYPE html>
    <!-- IE bug fix: always pad the error page with enough characters such that it is greater than 512 bytes, even after gzip compression abcdefghijklmnopqrstuvwxyz1234567890aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz11223344556677889900abacbcbdcdcededfefegfgfhghgihihjijikjkjlklkmlmlnmnmononpopoqpqprqrqsrsrtstsubcbcdcdedefefgfabcadefbghicjkldmnoepqrfstugvwxhyz1i234j567k890laabmbccnddeoeffpgghqhiirjjksklltmmnunoovppqwqrrxsstytuuzvvw0wxx1yyz2z113223434455666777889890091abc2def3ghi4jkl5mno6pqr7stu8vwx9yz11aab2bcc3dd4ee5ff6gg7hh8ii9j0jk1kl2lmm3nnoo4p5pq6qrr7ss8tt9uuvv0wwx1x2yyzz13aba4cbcb5dcdc6dedfef8egf9gfh0ghg1ihi2hji3jik4jkj5lkl6kml7mln8mnm9ono-->
    <html lang="zh-CN">
    <head>
    <meta charset="<?php echo SITE_CHARSET; ?>">
    <title><?php echo $sTitle; ?> - <?php echo SITE_NAME; ?></title>
    <style>
        html {
            background : #4786B3;
        }

        body {
            margin           : 0;
            padding          : 60px;
            font             : 14px/18px Arial, Helvetica, sans-serif;
            color            : #FFFFFF;
            background-color : transparent;
        }

        h1, p {
            text-align : center;
        }

        h1 {
            margin      : 30px 0 0;
            font        : bold 40px/40px Arial, Helvetica, sans-serif;
            text-shadow : 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        p {
            margin : 10px 0 20px;
            font   : 300 18px/25px Arial, Helvetica, sans-serif;
            color  : #E0EFF6;
        }
    </style>
    </head>
    <body>
    <h1><?php echo $sTitle; ?></h1>

    <p><?php echo $sMessage; ?></p>
    </body>
    </html>
    <?php
    exit;
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
 * @param array $aData 模板中可供调用的变量，以数组键值对（Key => Value）形式撰写，经过处理后，数组键（Key）作为变量名，数组键（Value）作为变量的值
 * @param string $sTemplate 模板名称
 * @param string $sGroup 模板组
 */
function _view(array $aData = array(), $sTemplate = 'default', $sGroup = 'web') {
    $_SERVER['NP_TEMPLATE'] = $sTemplate;
    $_SERVER['NP_TEMPLATE_GROUP'] = $sGroup;
    $sTemplatePath = NP_APP_DIR . '/view/' . $sGroup . '/' . $sTemplate . '.php';
    if (file_exists($sTemplatePath)) {
        is_array($aData) and extract($aData);
        require $sTemplatePath;
    } else {
        $sTemplatePath = NP_FRAMEWORK_DIR . '/view/' . $sGroup . '/' . $sTemplate . '.php';
        if (file_exists($sTemplatePath)) {
            is_array($aData) and extract($aData);
            require $sTemplatePath;
        }
    }
}