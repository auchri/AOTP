<?php

namespace AOTP\sites\aotp;

use AOTP\Alert;
use AOTP\Config;
use AOTP\Site;

class Install extends Site
{

    function getTitle() {
        return 'Installation';
    }

    function getOutput() {
        ?>
        <h1>Installation</h1>
        <?php
        //TODO: Finish installation script (database)
        if (Config::getInstance()->isUserConfigured()) {
            (new Alert(Alert::TYPE_WARNING, 'Installation is already complete!'))->show();
            ?>
            <a href="<?= URI_ROOT ?>">Back to start site</a>
            <?php
        } else {
            echo 'Enter database credentials.....';
        }
    }
}