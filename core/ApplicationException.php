<?php
/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：ApplicationException.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-25 11:09
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

/**
 * Class ApplicationException 全局异常捕获器
 */
class ApplicationException extends Exception {
    /**
     * 获取异常消息（HTML格式）
     * @return string
     */
    public function getMessageAsHtml() {
        return str_replace(array('{Code}', '{Message}'),
                           array($this->getCode(), $this->getMessage()),
            <<<'HTML'
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>Application Error</title>
<style type="text/css">
    .message {
        padding          : 10px;
        background-color : red;
        color            : white;
    }
    .trace {
        padding          : 10px;
        background-color : yellow;
        color            : black;
    }
</style>
</head>
<body>
<h1>Application Error</h1>
<p class="message">
    [{Code}] {Message}
</p>
</body>
</html>
HTML
        );
    }

    /**
     * 获取跟踪报告（HTML 格式）
     * @return string
     */
    public function getTraceAsHtml() {
        return str_replace(array('{Code}', '{Message}', '{Trace}'),
                           array($this->getCode(), $this->getMessage(), nl2br($this->getTraceAsString())),
            <<<'HTML'
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>Application Error</title>
<style type="text/css">
    .message {
        padding          : 10px;
        background-color : red;
        color            : white;
    }
    .trace {
        padding          : 10px;
        background-color : yellow;
        color            : black;
    }
</style>
</head>
<body>
<h1>Application Error</h1>
<p class="message">
    [{Code}] {Message}
</p>
<h2>PHP Debug</h2>
<p class="trace">
    {Trace}
</p>
</body>
</html>
HTML
        );
    }
}