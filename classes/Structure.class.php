<?php

namespace AOTP;

class Structure
{
    private static $instance;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    public function includeHeader($title) {
        if (is_string($title)) {
            $title = array($title);
        }

        $title[] = 'AOTP';
        $title   = implode(' | ', $title);

        /** @noinspection PhpIncludeInspection */
        include DIR_STRUCTURE . 'header.php';
    }

    public function includeFooter() {
        /** @noinspection PhpIncludeInspection */
        include DIR_STRUCTURE . 'footer.php';
    }
}