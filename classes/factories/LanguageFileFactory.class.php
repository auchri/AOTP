<?php

namespace AOTP\factories;

use AOTP\Config;
use AOTP\LanguageFile;
use DirectoryIterator;

class LanguageFileFactory
{

    /**
     * @param Config $config
     *
     * @return LanguageFile[]
     */
    public static function getDefaultFiles(Config $config) {
        $files = array();

        $defaultLanguage          = $config->getValue(Config::KEY_DEFAULT_LANG);
        $defaultLanguageDirectory = $config->getDefaultLanguageDirectory();

        foreach (new DirectoryIterator($defaultLanguageDirectory) as $langFile) {
            if ($langFile->isDot()) continue;

            if ($langFile->isFile()) {
                $languageFile = new LanguageFile($config);
                $languageFile->setFilename($langFile->getFilename());
                $languageFile->setLanguage($defaultLanguage);
                $files[] = $languageFile;
            }
        }

        return $files;
    }
}