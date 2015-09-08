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

    private $userConfigFiles = array(
        'user.php'
    );

    private $isUserConfigured;

    public function getValue($key) {
        return $this->config[$key];
    }

    public function getDefaultLanguageDirectory() {
        return DIR_LANGUAGES . $this->getValue(self::KEY_DEFAULT_LANG) . DIRECTORY_SEPARATOR;
    }

    public function isUserConfigured() {
        if ($this->isUserConfigured == null) {
            $isConfigured = true;

            foreach ($this->userConfigFiles as $configFile) {
                $isConfigured = $isConfigured && file_exists(DIR_CONFIG . $configFile) && is_file(DIR_CONFIG . $configFile);

                if (!$isConfigured) {
                    break;
                }
            }
            $this->isUserConfigured = $isConfigured;
        }

        return $this->isUserConfigured;
    }

    public function getUserConfigFiles() {
        return $this->userConfigFiles;
    }

    /**
     * Creates a config file from the template and replaces the placeholders with the values
     *
     * @param string $name
     * @param array  $values
     */
    public function createConfigFileWithValue($name, array $values) {
        $templateFile = DIR_CONFIG_TEMPLATES . $name;
        $realFile     = DIR_CONFIG . $name;

        if (!Filesystem::fileExists($templateFile)) {
            throw new \InvalidArgumentException('The give config file (' . $name . ') does not exist');
        }

        $templateContent = file_get_contents($templateFile);
        $keys            = array_keys($values);
        $values          = array_values($values);

        $newContent = str_replace($keys, $values, $templateContent);
        file_put_contents($realFile, $newContent);
    }
}