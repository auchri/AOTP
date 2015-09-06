<?php

require_once 'config/main.php';

$language        = isset($_GET['language']) ? trim($_GET['language']) : '';
$langFile        = isset($_GET['file']) ? $langDir . $language . DIRECTORY_SEPARATOR . trim($_GET['file']) : '';
$defaultLangFile = isset($_GET['file']) ? $langDir . $defaultLang . DIRECTORY_SEPARATOR . trim($_GET['file']) : '';

if (empty($language) || !array_key_exists($language, $toTranslate) || empty($defaultLangFile) || !file_exists($defaultLangFile)) {
    header('Location: /');
    exit();
}

function getStringsFromFile($file) {
    $strings = array();
    if (file_exists($file) && is_file($file)) {
        $content = file_get_contents($file);
        preg_match_all("/<string name=\"([^\"]+)\">(.*)<\/string>/", $content, $matches);
        $nStrings = count($matches[1]);

        for ($i = 0; $i < $nStrings; $i++) {
            $strings[$matches[1][$i]] = $matches[2][$i];
        }
    }

    return $strings;
}

$defaultStrings    = getStringsFromFile($defaultLangFile);
$translatedStrings = getStringsFromFile($langFile);

?>
<table>
    <tr>

        <th>Key</th>
        <th>Original (<?= $defaultLang ?>)</th>
        <th>Übersetzt (<?= $language ?>)</th>
    </tr>
    <?php
    foreach ($defaultStrings as $key => $string) {
        $translatedString = array_key_exists($key, $translatedStrings) ? $translatedStrings[$key] : '';
        ?>
        <tr>
            <td><?= $key ?></td>
            <td><?= $string ?></td>
            <td><?= $translatedString ?></td>
        </tr>
        <?php
    }

    ?>
</table>

<a href="/">Zurück</a>