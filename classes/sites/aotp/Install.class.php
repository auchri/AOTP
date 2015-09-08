<?php

namespace AOTP\sites\aotp;

use AOTP\Alert;
use AOTP\Common;
use AOTP\Config;
use AOTP\Database;
use AOTP\Filesystem;
use AOTP\Site;

/**
 * Class for installing AOTP
 *
 * @package AOTP\sites\aotp
 */
class Install extends Site
{
    private $step;
    private $errorMessage = '';

    const KEY_STEP = 'step';
    const STEP_DATABASE = 1;

    const STEP_COMPLETE = 9999;

    public function prepare() {
        if (!Config::getInstance()->isUserConfigured() &&
            (!isset($_GET[self::KEY_STEP]) || !is_numeric($_GET[self::KEY_STEP]) || $_GET[self::KEY_STEP] < self::STEP_DATABASE)
        ) {
            Common::redirectToQuery(self::KEY_STEP, self::STEP_DATABASE);
        }

        $this->step = $_GET[self::KEY_STEP];

        if (isset($_POST['s'])) {
            $this->handlePost();
        }
    }

    public function getTitle() {
        return 'Installation';
    }

    public function getOutput() {
        ?>
        <h1>Installation</h1>
        <?php
        if (Config::getInstance()->isUserConfigured() && $this->step != self::STEP_COMPLETE) {
            (new Alert(Alert::TYPE_WARNING, 'Installation is already complete!'))->show();
            ?>
            <a class="button" href="<?= URI_ROOT ?>">&laquo; Back to start site</a>
            <?php
        } else if ($this->step == self::STEP_DATABASE) {
            ?>
            <p><strong>Database credentials</strong></p>
            <?php
            $host     = '';
            $username = '';
            $password = '';
            $database = '';

            if (isset($_POST['s'])) {
                echo $this->errorMessage;
                $host     = isset($_POST['database_host']) ? Common::sanitizeString($_POST['database_host']) : '';
                $username = isset($_POST['database_user']) ? Common::sanitizeString($_POST['database_user']) : '';
                $password = isset($_POST['database_password']) ? Common::sanitizeString($_POST['database_password']) : '';
                $database = isset($_POST['database_name']) ? Common::sanitizeString($_POST['database_name']) : '';
            }
            ?>
            <form method="post" autocomplete="off">
                <label><span>Host:</span><input type="text" name="database_host" value="<?= $host ?>"></label>
                <label><span>Username:</span><input type="text" name="database_user" value="<?= $username ?>"></label>
                <label><span>Password:</span><input type="password" name="database_password" value="<?= $password ?>"></label>
                <label><span>Database:</span><input type="text" name="database_name" value="<?= $database ?>"></label>
                <input type="submit" value="Try to connect" name="s">
            </form>
            <?php
        } else {
            Filesystem::deleteRecursive(DIR_INSTALLATION, true);
            (new Alert(Alert::TYPE_SUCCESS, 'The installation is complete!'))->show();
            ?>
            <a class="button" href="<?= URI_ROOT ?>">Go to start site</a>
            <?php
        }
    }

    /**
     * Validates the post data
     */
    private function handlePost() {
        if ($this->step == self::STEP_DATABASE) {
            $data = $this->getDatabaseData();
            if (count($data) == 0) {
                $this->errorMessage = (new Alert(Alert::TYPE_ERROR, 'Please fill out all fields!'))->getHtml();
            } else {
                $checkValue = $this->isDatabaseDataOk($data);
                if ($checkValue !== true) {
                    $this->errorMessage = (new Alert(Alert::TYPE_ERROR, 'The connection to the database failed<br><em>' . $checkValue . '</em>'))->getHtml();
                } else {
                    // Create config file
                    Config::getInstance()->createConfigFileWithValue('user.php', array(
                        '{db_host}'     => $data['host'],
                        '{db_user}'     => $data['username'],
                        '{db_password}' => $data['password'],
                        '{db_name}'     => $data['database']
                    ));

                    // Create tables in database
                    $databaseFile = DIR_INSTALLATION . 'database.sql';
                    if (!Filesystem::fileExists($databaseFile)) {
                        throw new \Exception('File "' . $databaseFile . '" does not exist');
                    }
                    $sql = file_get_contents($databaseFile);
                    Database::getConnection()->query($sql);

                    Common::redirectToQuery(self::KEY_STEP, self::STEP_COMPLETE);
                }
            }
        }
    }

    /**
     * Checks if the connection to the database succeeds.
     *
     * @param $data array
     *
     * @return bool|string Returns true if the connection is ok, otherwise the error message is returned
     */
    private function isDatabaseDataOk(array $data) {
        try {
            Database::connect($data['host'], $data['username'], $data['password'], $data['database']);
        } catch (\PDOException $e) {
            return $e->getMessage();
        }

        return true;
    }

    /**
     * Returns the database data in an array. The array will be empty, if not all data were entered
     *
     * @return array
     */
    private function getDatabaseData() {
        $host     = isset($_POST['database_host']) ? trim($_POST['database_host']) : '';
        $username = isset($_POST['database_user']) ? trim($_POST['database_user']) : '';
        $password = isset($_POST['database_password']) ? trim($_POST['database_password']) : '';
        $database = isset($_POST['database_name']) ? trim($_POST['database_name']) : '';

        if (empty($host) || empty($username) || empty($password) || empty($database)) {
            return array();
        } else {
            return array(
                'host'     => $host,
                'username' => $username,
                'password' => $password,
                'database' => $database
            );
        }
    }
}