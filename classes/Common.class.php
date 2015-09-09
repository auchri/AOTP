<?php

namespace AOTP;

class Common
{
    private function __construct() {
    }

    public static function sendHeader($header, $replace = true) {
        if (!headers_sent()) {
            header($header, $replace);
        }
    }

    public static function sendResponseCode($code) {
        $messages = array(
            200 => 'Ok',
            204 => 'No Response',
            301 => 'Moved Permanently',
            302 => 'Found',
            304 => 'Not Modified',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable',
        );

        if (!array_key_exists($code, $messages)) {
            throw new \InvalidArgumentException('Response code not supported: ' . $code);
        }

        $key = 'HTTP/1.1';
        if (array_key_exists('SERVER_PROTOCOL', $_SERVER) && strlen($_SERVER['SERVER_PROTOCOL']) < 15 && strlen($_SERVER['SERVER_PROTOCOL']) > 1) {
            $key = $_SERVER['SERVER_PROTOCOL'];
        }

        $message = $messages[$code];
        self::sendHeader($key . ' ' . $code . ' ' . $message);
    }

    public static function redirect($url) {
        self::redirectNoExit($url);
        exit();
    }

    public static function redirectNoExit($url) {
        self::sendResponseCode(307);
        self::sendHeader('Location: ' . $url);
    }

    public static function sanitizeString($value) {
        return trim(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }
}