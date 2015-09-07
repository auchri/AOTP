<?php

use AOTP\factories\LanguageFileFactory;

require_once 'config/main.php';

$structure->includeHeader('Test');
?>
    <h1>Files</h1>
    <ul>
        <?php
        $files = LanguageFileFactory::getDefaultFiles($config);
        foreach ($files as $file) {
            ?>
            <li><a href="statistic.php?file=<?= $file->getFilename() ?>"><?= $file->getFilename() ?></a></li>
            <?php
        }
        ?>
    </ul>
<?php
$structure->includeFooter();