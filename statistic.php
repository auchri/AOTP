<?php

include 'conf.php';

$langPath = $langDir . $defaultLang . DIRECTORY_SEPARATOR;

$defaultLangFile = isset($_GET['file']) ? $langPath . trim($_GET['file']) : '';

if (empty($defaultLangFile) || !file_exists($defaultLangFile)) {
    header('Location: /');
    exit();
}

function getNumberOfStrings($file) {
    $content = file_get_contents($file);
    preg_match_all("/<string name=\"([^\"]+)\">(.*)<\/string>/", $content, $output_array);

    return count($output_array[1]);
}

$standardLangStrings = getNumberOfStrings($defaultLangFile);

$langStrings = array();
foreach ($toTranslate as $language => $longName) {
    $translateDir  = $langDir . $language . DIRECTORY_SEPARATOR;
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
<style type="text/css">
    .ok { color: #009900; }

    .warning { color: #FF9900; }

    .error { color: #CC0000; }

    a { color: inherit; }
</style>
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

        echo '<li class="' . $class . '"><a href="strings.php?file=' . $_GET['file'] . '&amp;language=' . $language . '">' . $name . ': ' . $strings . ' (' . $percent . '%)</a></li>';
    }
    ?>
</ul>

<a href="/">Zurück</a>