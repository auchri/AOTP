<?php

use AOTP\Config;

define('NS_ROOT', 'AOTP\\');
define('NS_SITES', NS_ROOT . 'Sites\\');

define('DIR_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('DIR_INSTALLATION', DIR_ROOT . 'installation' . DIRECTORY_SEPARATOR);
define('DIR_CONFIG', DIR_ROOT . 'config' . DIRECTORY_SEPARATOR);
define('DIR_CONFIG_TEMPLATES', DIR_CONFIG . 'templates' . DIRECTORY_SEPARATOR);
define('DIR_CLASSES', DIR_ROOT . 'classes' . DIRECTORY_SEPARATOR);
define('DIR_LANGUAGES', DIR_ROOT . 'languages' . DIRECTORY_SEPARATOR);
define('DIR_STRUCTURE', DIR_ROOT . 'structure' . DIRECTORY_SEPARATOR);

define('URI_ROOT', '/');
define('URI_CSS', URI_ROOT . 'css/');

spl_autoload_register(function ($className) {
    $classPath = getClassPathFromName($className);

    if (doesClassExist($classPath)) {
        /** @noinspection PhpIncludeInspection */
        require_once($classPath);
    }
});

/**
 * Returns the file of the given class name
 *
 * @param string $className
 *
 * @return string
 */
function getClassPathFromName($className) {
    $prefix    = '---';
    $className = $prefix . $className;
    $className = str_replace($prefix . NS_ROOT, '', $className);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    return DIR_CLASSES . $className . '.class.php';
}

/**
 * Checks if the given class exists
 *
 * @param string $classPath
 *
 * @return bool
 */
function doesClassExist($classPath) {
    return file_exists($classPath) && is_file($classPath);
}

if (Config::getInstance()->isUserConfigured()) {
    $configFiles = Config::getInstance()->getUserConfigFiles();
    foreach ($configFiles as $file) {
        /** @noinspection PhpIncludeInspection */
        require_once(DIR_CONFIG . $file);
    }
}