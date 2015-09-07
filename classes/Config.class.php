<?php

namespace AOTP;

class Config extends Singleton
{
    const KEY_DEFAULT_LANG = "default_lang";
    const KEY_TO_TRANSLATE = "to_translate";

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

    public function getDefaultLanguageDirectory() {
        return DIR_LANGUAGES . $this->getValue(self::KEY_DEFAULT_LANG) . DIRECTORY_SEPARATOR;
    }
}