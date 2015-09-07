<?php

use AOTP\Config;
use AOTP\factories\LanguageFileFactory;
use AOTP\Structure;

require_once 'config/main.php';

Structure::getInstance()->includeHeader('Test');
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
Structure::getInstance()->includeFooter();