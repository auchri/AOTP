<h1>Android Translator</h1>
<h2>Dateien</h2>
<?php
ini_set("display_errors", 1);
include 'conf.php';

$files    = array();
$langPath = $langDir . $defaultLang . DIRECTORY_SEPARATOR;
foreach (new DirectoryIterator($langPath) as $langFile) {
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