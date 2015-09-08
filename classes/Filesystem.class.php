<?php

namespace AOTP;

use DirectoryIterator;

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

    /**
     * Checks if the given directory exists
     *
     * @param  string $path
     *
     * @return bool
     */
    public static function dirExists($path) {
        return file_exists($path) && is_dir($path);
    }

    /**
     * Deletes all the contents of a directory
     *
     * @param string     $dir
     * @param bool|false $deleteRoot
     */
    public static function deleteRecursive($dir, $deleteRoot = false) {
        if (!self::dirExists($dir)) {
            return;
        }

        foreach (new DirectoryIterator($dir) as $file) {
            if ($file->isDot()) continue;

            if ($file->isFile()) {
                unlink($file->getPathname());
            } elseif ($file->isDir()) {
                self::deleteRecursive($file->getPathname() . DIRECTORY_SEPARATOR, true);
            }
        }

        if ($deleteRoot) {
            rmdir($dir);
        }
    }
}