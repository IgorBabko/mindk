<?php
/**
 * File /Framework/Database.php contains Database class
 * which is extension for PDO.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\DatabaseException;

/**
 * Class which extends PDO by adding a couple of new properties.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Database extends PDO
{
    /**
     * @var string $engine Database engine (e.g. mysql, sqlite, pgsql)
     */
    protected $engine;

    /**
     * @var string $host Location of database
     */
    protected $host;

    /**
     * @var string $user Database user
     */
    protected $user;

    /**
     * @var string $pass Database pass
     */
    protected $pass;

    /**
     * @var string $db Database name
     */
    protected $db;

    /**
     * @var string $charset Database charset
     */
    protected $charset;

    /**
     * Constructor establishes connection with database server, sets charset and error reporting mode.
     *
     * @param string $user    Database user.
     * @param string $pass    Database password.
     * @param string $db      Database name.
     * @param string $engine  Database engine.
     * @param string $host    Database host.
     * @param string $charset Database charset.
     */
    public function __construct($user, $pass, $db, $engine = "mysql", $host = "localhost", $charset = "utf8")
    {
        $dsn = $engine.":dbname=".$db.";host=".$host;
        parent::__construct($dsn, $user, $pass);
        $this->exec("SET CHARACTER SET $charset");
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}