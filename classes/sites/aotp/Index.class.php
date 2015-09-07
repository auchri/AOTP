<?php

namespace AOTP\sites\aotp;

use AOTP\Config;
use AOTP\factories\LanguageFileFactory;
use AOTP\Site;

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