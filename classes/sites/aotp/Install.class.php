<?php

namespace AOTP\sites\aotp;

use AOTP\Alert;
use AOTP\Common;
use AOTP\Config;
use AOTP\Database;
use AOTP\Site;

/**
 * Class for installing AOTP
 *
 * @package AOTP\sites\aotp
 */
class Install extends Site
{

    function getTitle() {
        return 'Installation';
    }

    function getOutput() {
        ?>
        <h1>Installation</h1>
        <?php
        //TODO: Finish installation script (database)
        if (Config::getInstance()->isUserConfigured()) {
            (new Alert(Alert::TYPE_WARNING, 'Installation is already complete!'))->show();
            ?>
            <a class="button" href="<?= URI_ROOT ?>">&laquo; Back to start site</a>
            <?php
        } else {
            ?>
            <p><strong>Database credentials</strong></p>
            <?php
            $host     = '';
            $username = '';
            $password = '';
            $database = '';

            if (isset($_POST['s'])) {
                $this->handlePost();
                $host     = isset($_POST['database_host']) ? Common::getInstance()->sanitizeString($_POST['database_host']) : '';
                $username = isset($_POST['database_user']) ? Common::getInstance()->sanitizeString($_POST['database_user']) : '';
                $password = isset($_POST['database_password']) ? Common::getInstance()->sanitizeString($_POST['database_password']) : '';
                $database = isset($_POST['database_name']) ? Common::getInstance()->sanitizeString($_POST['database_name']) : '';
            }
            ?>
            <form method="post">
                <label><span>Host:</span><input type="text" name="database_host" value="<?= $host ?>"></label>
                <label><span>Username:</span><input type="text" name="database_user" value="<?= $username ?>"></label>
                <label><span>Password:</span><input type="password" name="database_password" value="<?= $password ?>"></label>
                <label><span>Database:</span><input type="text" name="database_name" value="<?= $database ?>"></label>
                <input type="submit" value="Try to connect" name="s">
            </form>
            <?php
        }
    }

    private function handlePost() {
        $data = $this->getDatabaseData();
        if (count($data) == 0) {
            (new Alert(Alert::TYPE_ERROR, 'Please fill out all fields!'))->show();
        } else {
            $checkValue = $this->isDatabaseDataOk($data);
            if ($checkValue === true) {
                // TODO: Save data to file
            } else {
                (new Alert(Alert::TYPE_ERROR, 'The connection to the database failed<br><em>' . $checkValue . '</em>'))->show();
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
    private
    function isDatabaseDataOk(array $data) {
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
    private
    function getDatabaseData() {
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