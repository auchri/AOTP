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
}