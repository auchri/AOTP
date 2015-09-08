<?php

namespace AOTP;

/**
 * Class for filesystem methods
 *
 * @package AOTP
 */
class Filesystem
{
    /**
     * Checks if the given file exists
     *
     * @param string $path
     *
     * @return bool
     */
    public static function fileExists($path) {
        return file_exists($path) && is_file($path);
    }
}