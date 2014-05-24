<?php

/**
 * User: 永强
 * Date: 2014/5/23
 * Time: 20:32
 */
class NikboboResponse extends NikboboObject
{
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

    public function __construct()
    {
    }

    /**
     * @param int $status_code
     * @return bool
     */
    public function setStatusCode($status_code)
    {
        if (isset($this->http_code[$status_code])) {
            $this->status_code = $status_code;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $content_type
     * @return bool
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;

        return true;
    }

    /**
     * @param string $charset
     * @return bool
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return true;
    }

    /**
     * @param string $header
     * @return bool
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;

        return true;
    }
} 