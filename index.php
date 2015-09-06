<?php

require_once 'config/main.php';

$structure->includeHeader("Test");
?>

    <h1>Android Open Translation Platform</h1>

    <h2>Dateien</h2>
<?php

$files                    = array();
$defaultLanguageDirectory = $config->getDefaultLanguageDirectory();

foreach (new DirectoryIterator($defaultLanguageDirectory) as $langFile) {
    if ($langFile->isDot()) continue;

    if ($langFile->isFile()) {
        $files[] = $langFile->getFilename();
    }
}

sort($files);

?>

    <ul>
        <?php
        foreach ($files as $file) {
            echo '<li><a href="statistic.php?file=' . $file . '">' . $file . '</a></li>';
        }
        ?>
    </ul>


<?php
$structure->includeFooter();