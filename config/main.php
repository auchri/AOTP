<?php

define('ROOT_NAMESPACE', 'AOTP');
define('DIR_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('DIR_CLASSES', DIR_ROOT . 'classes' . DIRECTORY_SEPARATOR);
define('DIR_LANGUAGES', DIR_ROOT . 'languages' . DIRECTORY_SEPARATOR);
define('DIR_STRUCTURE', DIR_ROOT . 'structure' . DIRECTORY_SEPARATOR);

define('URI_ROOT', '/');
define('URI_CSS', URI_ROOT . 'css/');

require_once('user.php');

spl_autoload_register(function ($className) {
    $prefix    = '---';
    $className = $prefix . $className;
    $className = str_replace($prefix . ROOT_NAMESPACE . '\\', '', $className);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    /** @noinspection PhpIncludeInspection */
    require_once(DIR_CLASSES . $className . '.class.php');
});