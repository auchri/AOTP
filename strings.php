<?php

use AOTP\Config;

require_once 'config/main.php';

$language        = isset($_GET['language']) ? trim($_GET['language']) : '';
$langFile        = isset($_GET['file']) ? DIR_LANGUAGES . $language . DIRECTORY_SEPARATOR . trim($_GET['file']) : '';
$defaultLangFile = isset($_GET['file']) ? $config->getDefaultLanguageDirectory() . trim($_GET['file']) : '';
$toTranslate     = $config->getValue(Config::KEY_TO_TRANSLATE);
$defaultLang     = $config->getValue(Config::KEY_DEFAULT_LANG);

if (empty($language) || !array_key_exists($language, $toTranslate) || empty($defaultLangFile) || !file_exists($defaultLangFile)) {
    header('Location: /');
    exit();
}

$_GET['file'] = trim($_GET['file']);

function getStringsFromFile($file) {
    $strings = array();
    if (file_exists($file) && is_file($file)) {
        $content = file_get_contents($file);
        preg_match_all("/<string name=\"([^\"]+)\">(.*)<\\/string>/", $content, $matches);
        $nStrings = count($matches[1]);

        for ($i = 0; $i < $nStrings; $i++) {
            $strings[$matches[1][$i]] = $matches[2][$i];
        }
    }

    return $strings;
}

$defaultStrings    = getStringsFromFile($defaultLangFile);
$translatedStrings = getStringsFromFile($langFile);

$structure->includeHeader(array($language, $_GET['file']));

?>
    <h1>File <?= $_GET['file'] ?> - <?= $language ?></h1>
    <table>
        <tr>

            <th>Key</th>
            <th>Original (<?= $defaultLang ?>)</th>
            <th>Translated (<?= $language ?>)</th>
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

    <a href="<?= URI_ROOT ?>statistic.php?file=<?= $_GET['file'] ?>">Back</a>

<?php
$structure->includeFooter();