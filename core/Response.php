<?php

/**
 * 该文件使用 PhpStorm 创建，具体信息如下：
 * 所属项目：Nikbobo PHP Framework
 * 初始文件名：Respond.php
 * 创建者：Nikbobo
 * 创建时间：2014-05-24 19:25
 */

defined('IN') or exit('Access Denied'); // 载入安全检查

/**
 * Class Respond 头响应器
 */
class Response {
    private static $instance;
    private $http_code = array(100 => 'Continue',
                               101 => 'Switching Protocols',
                               200 => 'OK',
                               201 => 'Created',
                               202 => 'Accepted',
                               203 => 'Non-Authoritative Information',
                               204 => 'No Content',
                               205 => 'Reset Content',
                               206 => 'Partial Content',
                               300 => 'Multiple Choices',
                               301 => 'Moved Permanently',
                               302 => 'Moved Temporarily',
                               303 => 'See Other',
                               304 => 'Not Modified',
                               305 => 'Use Proxy',
                               400 => 'Bad Request',
                               401 => 'Unauthorized',
                               402 => 'Payment Required',
                               403 => 'Forbidden',
                               404 => 'Not Found',
                               405 => 'Method Not Allowed',
                               406 => 'Not Acceptable',
                               407 => 'Proxy Authentication Required',
                               408 => 'Request Time-out',
                               409 => 'Conflict',
                               410 => 'Gone',
                               411 => 'Length Required',
                               412 => 'Precondition Failed',
                               413 => 'Request Entity Too Large',
                               414 => 'Request-URI Too Large',
                               415 => 'Unsupported Media Type',
                               500 => 'Internal Server Error',
                               501 => 'Not Implemented',
                               502 => 'Bad Gateway',
                               503 => 'Service Unavailable',
                               504 => 'Gateway Time-out',
                               505 => 'HTTP Version not supported');
    private $status_code = 200;
    private $charset = 'UTF-8';
    private $content_type = 'text/html';
    private $headers = array();

    private function __construct() { }

    /**
     * 创建响应
     * @return Response
     */
    public static function create() {
        if (empty(self::$instance))
            self::$instance = new Response();
        return self::$instance;
    }

    /**
     * 设置 HTTP 状态码
     * @param int $status_code HTTP 状态码
     * @return Response $this 返回对象本身以方便继续执行其他操作
     * @throws ApplicationException 未知状态码将抛出异常
     */
    public function setStatusCode($status_code = 200) {
        if (isset($this->http_code[$status_code])) {
            $this->status_code = $status_code;
            return $this;
        } else
            throw new ApplicationException('Unknown http status code "' .
                                           htmlentities($status_code) .
                                           '"', 108);
    }

    /**
     * 获取 HTTP 状态码
     * @return int 准备发送的 HTTP 状态码
     */
    public function getStatusCode() {
        return $this->status_code;
    }

    /**
     * 设置 Content Type
     * @param string $content_type HTTP Content Type
     * @return Response $this 返回对象本身以方便继续执行其他操作
     */
    public function setContentType($content_type) {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * 设置编码
     * @param string $charset 编码
     * @return Response $this 返回对象本身以方便继续执行其他操作
     */
    public function setCharset($charset) {
        $this->charset = $charset;
        return $this;
    }

    /**
     * 设置跳转
     * @param string $url         跳转到 URL
     * @param int    $status_code HTTP 状态码
     */
    public function setLocation($url, $status_code = 302) {
        switch ($status_code) {
            case 301:
                $this->setStatusCode(301);
                break;
            case 302:
                $this->setStatusCode(302);
                break;
            default:
                $this->setStatusCode(302);
                break;
        }
        $this->setHeader('Location', $url);
    }


    /**
     * 添加头部信息
     * @param string $key   Header 头
     * @param string $value 对应的值
     * @return Response $this 返回对象本身以方便继续执行其他操作
     */
    public function setHeader($key, $value) {
        $key             = str_replace(' ', '-', ucwords(str_replace('-', ' ', $key)));
        $this->headers[] = $key . ': ' . $value;
        return $this;
    }

    /**
     * 执行响应
     */
    public function respond() {
        if (headers_sent())
            throw new ApplicationException('Headers already sent', 109);

        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        header($protocol . ' ' . $this->status_code . ' ' . $this->http_code[$this->status_code],
               true,
               $this->status_code);
        header('Content-Type: ' . $this->content_type . '; charset=' . $this->charset);
        foreach ($this->headers as $header) {
            header($header, true);
        }
        header('X-Powered-By: Nikbobo PHP Framework', true);
        self::$instance = null;
    }
} 