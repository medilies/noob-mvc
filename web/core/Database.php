<?php
/*
 *
 */

namespace Core;

use Exception;
use PDO;
use PDOException;

class Database
{

    protected $Selector;
    protected $Inserter;
    protected $Updater;
    protected $Deleter;

    /**
     * Return a PDO connection object
     */
    protected function connection(string $user_name, string $user_password): PDO
    {
        $pdo_driver = DB_PDO_DRIVER;
        $host_name = Utility::getenv('DB_SERVER', FALLBACK_DB_SERVER);
        $db_name = Utility::getenv('DB_NAME', FALLBACK_DB_NAME);
        $db_port = Utility::getenv('DB_PORT', FALLBACK_DB_PORT);

        $dsn = "$pdo_driver:host=$host_name;port=$db_port;dbname=$db_name";

        try {

            $cnx = new PDO($dsn, $user_name, $user_password);

            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $cnx->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $cnx->setAttribute(PDO::ATTR_PERSISTENT, ATTR_PERSISTENT);
            $cnx->setAttribute(PDO::ATTR_EMULATE_PREPARES, ATTR_EMULATE_PREPARES);
            $cnx->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, ATTR_STRINGIFY_FETCHES);

            return $cnx;

        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), 500);
        }

    }

    /**
     * Insure least privileges users security concept
     *
     * Used inside Model's constructors
     * Set the empty inherited properties $Selector, $Inserter, $Updater & $Deleter
     * to become PDO connections with MySQL users. Using the connection() method
     * @throws Exception
     */
    public function set_db_users(array $required_privileges = ['SELECT', 'INSERT', 'UPDATE', 'DELETE']): void
    {

        if (in_array('SELECT', $required_privileges)) {
            $user = Utility::getenv('DB_USERNAME_SELECT', FALLBACK_DB_USERNAME);
            $pass = Utility::getenv('DB_PASS_SELECT', FALLBACK_DB_PASS);
            $this->Selector = $this->connection($user, $pass);
        }

        if (in_array('INSERT', $required_privileges)) {
            $user = Utility::getenv('DB_USERNAME_INSERT', FALLBACK_DB_USERNAME);
            $pass = Utility::getenv('DB_PASS_INSERT', FALLBACK_DB_PASS);
            $this->Inserter = $this->connection($user, $pass);
        }

        if (in_array('UPDATE', $required_privileges)) {
            $user = Utility::getenv('DB_USERNAME_UPDATE', FALLBACK_DB_USERNAME);
            $pass = Utility::getenv('DB_PASS_UPDATE', FALLBACK_DB_PASS);
            $this->Updater = $this->connection($user, $pass);
        }

        if (in_array('DELETE', $required_privileges)) {
            $user = Utility::getenv('DB_USERNAME_DELETE', FALLBACK_DB_USERNAME);
            $pass = Utility::getenv('DB_PASS_DELETE', FALLBACK_DB_PASS);
            $this->Deleter = $this->connection($user, $pass);
        }

    }

}
