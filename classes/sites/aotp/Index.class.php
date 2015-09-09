<?php

namespace AOTP\Sites\AOTP;

use AOTP\Config;
use AOTP\Factories\LanguageFileFactory;
use AOTP\Site;

/**
 * Class Index
 *
 * @package AOTP\Sites\AOTP
 */
class Index extends Site
{

    function getTitle() {
        return 'Home';
    }

    function getOutput() {
        ?>
        <h1>Files</h1>
        <ul>
            <?php
            $files = LanguageFileFactory::getDefaultFiles(Config::getInstance());
            foreach ($files as $file) {
                ?>
                <li><a href="statistic.php?file=<?= $file->getFilename() ?>"><?= $file->getFilename() ?></a></li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
}