<?php

namespace AOTP;

class Config
{
    const KEY_DEFAULT_LANG = "default_lang";
    const KEY_TO_TRANSLATE = "to_translate";

    private static $instance;

    private $config = array(
        self::KEY_DEFAULT_LANG => 'de',
        self::KEY_TO_TRANSLATE => array(
            'en' => 'Englisch',
            'tr' => 'Türkisch',
            'bs' => 'Bosnisch')
    );

    public function getValue($key) {
        return $this->config[$key];
    }

    private function __construct() {

    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDefaultLanguageDirectory() {
        return DIR_LANGUAGES . $this->getValue(self::KEY_DEFAULT_LANG) . DIRECTORY_SEPARATOR;
    }
}