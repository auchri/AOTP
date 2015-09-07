<?php

namespace AOTP\sites\aotp;

use AOTP\Config;
use AOTP\Site;

class Install extends Site
{

    function getTitle() {
        return 'Installation';
    }

    function getOutput() {
        //TODO: Finish installation script (database)
        if (Config::getInstance()->isUserConfigured()) {
            return 'Installation is already complete';
        } else {
            return 'Enter database credentials.....';
        }
    }
}