<?php

namespace AOTP;

/**
 * Abstract base class for sites
 *
 * @package AOTP
 */
abstract class Site
{
    abstract function getOutput();

    abstract function getTitle();

    /**
     * This method is called before any html is output
     */
    public function prepare() {

    }
}