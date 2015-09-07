<?php

use AOTP\Config;

include 'config/main.php';

$defaultLangFile = isset($_GET['file']) ? $config->getDefaultLanguageDirectory() . trim($_GET['file']) : '';

if (empty($defaultLangFile) || !file_exists($defaultLangFile)) {
    header('Location: /');
    exit();
}

$_GET['file'] = trim($_GET['file']);

$structure->includeHeader($_GET['file']);

function getNumberOfStrings($file) {
    $content = file_get_contents($file);
    preg_match_all("/<string name=\"([^\"]+)\">(.*)<\\/string>/", $content, $output_array);

    return count($output_array[1]);
}

$standardLangStrings = getNumberOfStrings($defaultLangFile);

$toTranslate = $config->getValue(Config::KEY_TO_TRANSLATE);
$langStrings = array();
foreach ($toTranslate as $language => $longName) {
    $translateDir  = DIR_LANGUAGES . $language . DIRECTORY_SEPARATOR;
    $translateFile = $translateDir . $_GET['file'];
    $strings       = 0;

    if (file_exists($translateFile) && is_file($translateFile)) {
        $strings = getNumberOfStrings($translateFile);
    } else if (!file_exists($translateDir) || !is_dir($translateDir)) {
        mkdir($translateDir, 777, true);
    }

    $langStrings[$language] = $strings;
}
arsort($langStrings);
?>
    <h1>File <?= $_GET['file'] ?></h1>
    Strings to translate: <?= $standardLangStrings ?>
    <h2>Status</h2>
    <ul>
        <?php
        foreach ($langStrings as $language => $strings) {
            $percent = $strings / $standardLangStrings * 100;
            if ($percent < 30) {
                $class = 'error';
            } else if ($percent < 100) {
                $class = 'warning';
            } else {
                $class = 'ok';
            }

            $name = $toTranslate[$language] . ' (' . $language . ')';

            echo '<li class="' . $class . '"><a class="' . $class . '" href="strings.php?file=' . $_GET['file'] . '&amp;language=' . $language . '">' . $name . ': ' . $strings . ' (' . $percent . '%)</a></li>';
        }
        ?>
    </ul>

    <a href="/">Zurück</a>

<?php
$structure->includeFooter();