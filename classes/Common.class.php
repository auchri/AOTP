<?php

namespace AOTP;

class Common extends Singleton
{
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

    /**
     * Adds the give query parameter to the actual uri
     *
     * @param $name  string
     * @param $value string
     */
    public static function redirectToQuery($name, $value) {
        self::redirectToQueries(array($name => $value));
    }

    /**
     * Redirects to a set of query parameters: [name => value, name2 => value2]
     *
     * @param array $array
     */
    public static function redirectToQueries(array $array) {
        $parameters = array();
        $parsedUrl  = parse_url($_SERVER['REQUEST_URI']);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $parameters);
        }

        $parameters = array_merge($parameters, $array);

        self::redirect(URI_ROOT . 'index.php?' . http_build_query($parameters));
    }

    public static function sanitizeString($value) {
        return trim(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    }
}