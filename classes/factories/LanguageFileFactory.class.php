<?php

namespace AOTP\Factories;

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
                $languageFile->setNStrings(self::getNumberOfStringsInFile($langFile->getPathname()));
                $languageFile->setFilename($langFile->getFilename());
                $languageFile->setLanguage($defaultLanguage);
                $files[] = $languageFile;
            }
        }

        return $files;
    }

    /**
     * Returns the number if string in a file
     *
     * @param $file
     *
     * @return int
     */
    private static function getNumberOfStringsInFile($file) {
        if (!file_exists($file) || !is_file($file)) {
            return 0;
        }

        $content = file_get_contents($file);
        preg_match_all("/<string name=\"([^\"]+)\">(.*)<\\/string>/", $content, $output_array);

        return count($output_array[1]);
    }
}