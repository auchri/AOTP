<?php

namespace AOTP;

class FrontController extends Singleton
{
    private static $title;
    private static $content;

    public function setTitle($title) {
        self::$title = $title;
    }

    public function setContent($content) {
        self::$content = $content;
    }

    public function printPage() {
        Structure::getInstance()->includeHeader(self::$title);
        echo self::$content;
        Structure::getInstance()->includeFooter();
    }
}