<?php
/**
 * File /framework/database/Database.php contains Database class
 * which is extension for PDO.
 *
 * PHP version 5
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Database;

use Framework\Exception\DatabaseException;

/**
 * Class which extends PDO by adding a couple of new properties.
 * Default implementation of {@link DatabaseInterface}.
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Database extends \PDO implements DatabaseInterface
{
    /**
     * @var string $engine Database engine (e.g. mysql, sqlite, pgsql)
     */
    protected $_engine;

    /**
     * @var string $host Location of database
     */
    protected $_host;

    /**
     * @var string $user Database user
     */
    protected $_user;

    /**
     * @var string $pass Database pass
     */
    protected $_pass;

    /**
     * @var string $db Database name
     */
    protected $_db;

    /**
     * @var string $charset Database charset
     */
    protected $_charset;

    /**
     * Constructor establishes connection with database server, sets charset and error reporting mode.
     *
     * @param string $user    Database user.
     * @param string $pass    Database password.
     * @param string $db      Database name.
     * @param string $engine  Database engine.
     * @param string $host    Database host.
     * @param string $charset Database charset.
     *
     * @throws DatabaseException DatabaseException instance.
     *
     * @return Database Database object.
     */
    public function __construct($user, $pass, $db, $engine = "mysql", $host = "localhost", $charset = "utf8")
    {
        if (is_string($user) && is_string($pass) && is_string($db)) {
            $this->_engine  = $engine;
            $this->_host    = $host;
            $this->_user    = $user;
            $this->_pass    = $pass;
            $this->_db      = $db;
            $this->_charset = $charset;
            $dsn            = $engine.":dbname=".$db.";host=".$host;
            parent::__construct($dsn, $user, $pass);
            $this->exec("SET CHARACTER SET $charset");
            $this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
        } else {
            throw new DatabaseException(
                500,
                "<strong>Internal server error:</strong> 'user', 'pass' and 'db' must be specified for Database::__construct method"
            );
        }
    }
}