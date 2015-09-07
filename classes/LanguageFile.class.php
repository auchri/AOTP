<?php

namespace AOTP;

class LanguageFile
{
    /**
     * @var string Filename
     */
    private $filename;

    /**
     * @var string Language of the file
     */
    private $language;

    /**
     * @var boolean If the file equals the default language
     */
    private $isDefaultLanguage;

    /**
     * @var Config Configuration object
     */
    private $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language) {
        $this->language          = $language;
        $this->isDefaultLanguage = $language == $this->config->getValue(Config::KEY_DEFAULT_LANG);
    }

    /**
     * @return boolean
     */
    public function isDefaultLanguage() {
        return $this->isDefaultLanguage;
    }
}