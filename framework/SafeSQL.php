<?php
/**
 * File /Framework/SafeSQL.php contains the SafeSQL class
 * which provides secure interaction with database.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\SafeSQLException;
use \PDO;
use \PDOStatement;

require_once('QueryBuilder.php');

/**
 * Class SafeSQL is used to make safe sql request to database.
 *
 * Class uses QueryBuilder::rawQueryString and QueryBuilder::bindParameters to
 * to bind parameters instead of placeholders in QueryBuilder::rawQueryString
 * filtering them in appropriate way before binding.
 *
 * Placeholder types and filter methods associated with them:
 *     - ?i => SafeSQL::escapeIdentifier;
 *     - ?n => SafeSQL::escapeNumber;
 *     - ?s => SafeSQL::escapeString.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SafeSQL extends PDO
{
    /**
     * @var null|PDOStatement $sqlResultSet PDOStatement object which holds data obtained from database
     */
    private $sqlResultSet = null;
    /**
     * @var null|array $resultSet Array of data fetched from PDOStatement object
     */
    private $resultSet = null;
    /**
     * @var null|int $numOfRows Holds number of rows fetched by the last 'SELECT' request to database
     */
    private $numOfRows = null;
    /**
     * @var null|int $numOfColumns Holds number of columns fetched by the last 'SELECT' request to database
     */
    private $numOfColumns = null;
    /**
     * @var null|integer $numOfAffectedRows Holds number of rows in database affected by the
     *                                      last 'INSERT', 'UPDATE', OR 'DELETE' requests.
     */
    private $numOfAffectedRows = null;

    /**
     * SafeSQL constructor establishes connection with database.
     *
     * @param string $engine  Type of database server (e.g. mysql).
     * @param string $host    Hostname.
     * @param string $db      Database name.
     * @param string $user    Username.
     * @param string $pass    User password.
     * @param string $charset Charset.
     *
     * @return SafeSQL instance.
     */
    public function __construct(
        $engine = 'mysql',
        $host = 'localhost',
        $db = null,
        $user = null,
        $pass = null,
        $charset = null
    ) {
        $dns = $engine.":dbname=".$db.";host=".$host;
        parent::__construct($dns, $user, $pass);
        $this->exec("SET CHARACTER SET $charset");
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Method to get number of rows in database affected by the
     * last 'INSERT', 'UPDATE', OR 'DELETE' requests.
     *
     * @return int Number of affected rows.
     */
    public function getNumOfAffectedRows()
    {
        return $this->numOfAffectedRows;
    }


    /**
     * Method to get number of columns fetched by the last 'SELECT' request to database.
     *
     * @return mixed
     */
    public function getNumOfColumns()
    {
        return $this->numOfColumns;
    }

    /**
     * Method to get number of rows fetched by the last 'SELECT' request to database.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return int Number of rows.
     */
    public function getNumOfRows()
    {
        if ($this->resultSet !== null) {
            return count($this->resultSet);
        } else {
            throw new SafeSQLException('001', "Can not get number of rows if SafeSQL::resultSet is undefined");
        }
    }


    /**
     * Method to get first fetched value from sql result set.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return mixed First fetched value from sql result set.
     */
    public function getOne()
    {
        if (isset($this->resultSet)) {
            return reset($this->resultSet[0]);
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::resultSet is undefined");
        }
    }

    /**
     * Method to get specified row from sql result set.
     *
     * @param int $rowIndex Index of row to get.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return array Specified row from sql result set.
     */
    public function getRow($rowIndex = 1)
    {
        if (isset($this->resultSet)) {
            if ($this->numOfRows > $rowIndex && $rowIndex >= 1) {
                return $this->resultSet[--$rowIndex];
            } else {
                throw new SafeSQLException('003', "specified row index doesn't belong to range [1; SafeSQL::numOfRows]");
            }
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::resultSet is undefined");
        }
    }

    /**
     * Method to get specified column from sql result set.
     *
     * @param int $columnIndex Index of column to get.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return array Specified column from sql result set.
     */
    public function getColumn($columnIndex = 1)
    {
        $column       = array();
//        $numOfColumns = count($this->resultSet[0]);
        if (isset($this->resultSet)) {
            if ($this->numOfColumns >= $columnIndex && $columnIndex >= 1) {
                foreach ($this->resultSet as $row) {
                    $counter = 0;
                    foreach ($row as $value) {
                        $counter++;
                        if ($columnIndex == $counter) {
                            $column[] = $value;
                            break;
                        }
                    }
                }
                return $column;
            } else {
                throw new SafeSQLException('004', "specified column index doesn't belong to range [1; SafeSQL::numOfColumns]");
            }
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::resultSet is undefined");
        }
    }

    /**
     * Method to get all fetched data from sql result set.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return array Fetched data from sql result set.
     */
    public function getAll()
    {
        if (isset($this->resultSet)) {
            return $this->resultSet;
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::resultSet is undefined");
        }
    }

    /**
     * Method to make safe sql request to database.
     *
     * It returns data fetched from the database if there was 'SELECT' request
     * otherwise nothing returns. In the case of request failure method throws an error.
     *
     * @param string $rawQueryString Query string QueryBuilder::rawQueryString with placeholders.
     * @param array $bindParameters  Parameters QueryBuilder::bindParameters to replace placeholders
     *                               in QueryBuilder::rawQueryString.
     *
     * @throws SafeSQLException SafeSQLException object.
     * @return void|array Array of data fetched from the database if there was 'SELECT' request
     *                    otherwise it returns void.
     */
    public function safeQuery($rawQueryString, $bindParameters)
    {
        $queryString = $this->prepareQuery($rawQueryString, $bindParameters);
        if (strpos($queryString, "SELECT") !== false) {
            $this->sqlResultSet = $this->query($queryString);
            if ($this->sqlResultSet !== false) {
                $this->resultSet = array();
                while ($row = $this->sqlResultSet->fetch(PDO::FETCH_ASSOC)) {
                    $this->resultSet[] = $row;
                }
                $this->numOfRows = count($this->resultSet);
                $this->numOfColumns = count($this->resultSet[0]);
                return $this->resultSet;
            } else {
                throw new SafeSQLException('005', "sql request is failed");
            }
        } else {
            $this->numOfAffectedRows = $this->exec($queryString);
            if ($this->numOfAffectedRows === false) {
                $this->numOfAffectedRows = null;
                throw new SafeSQLException('005', "sql request is failed");
            }
        }
    }

    /**
     * Method to replace placeholders in QueryBuilder::rawQueryString with its particular
     * QueryBuilder::bindParameters and escape them before replacing.
     *
     * @param string $rawQueryString Query string QueryBuilder::rawQueryString with placeholders.
     * @param array  $bindParameters Parameters QueryBuilder::bindParameters to replace placeholders
     *                               in QueryBuilder::rawQueryString.
     *
     * @return string Query string.
     */
    public function prepareQuery($rawQueryString, $bindParameters)
    {
        $queryString = '';
        $array       = preg_split('/(\?[isn])/', $rawQueryString, null, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($array as $index => $queryPart) {
            if (($index % 2) === 0) {
                $queryString .= $queryPart;
                continue;
            }
            switch ($queryPart) {
                case '?i':
                    $queryPart = $this->escapeIdentifier(array_shift($bindParameters));
                    break;
                case '?s':
                    $queryPart = $this->escapeString(array_shift($bindParameters));
                    break;
                case '?n':
                    $queryPart = $this->escapeNumber(array_shift($bindParameters));
            }
            $queryString .= $queryPart;
        }
        return $queryString;
    }

    /**
     * Method to escape number before binding it into query string.
     *
     * @param mixed $value Number to escape.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return mixed Escaped number.
     */
    public function escapeNumber($value = null)
    {
        if (!isset($value)) {
            throw new SafeSQLException('006', "Empty value for number (?n) placeholder");
        } elseif (is_numeric($value)) {
            if (is_integer($value)) {
                return $value;
            }
            $value = number_format($value, 0, '.', '');
            return $value;
        } else {
            throw new SafeSQLException('009', "Number (?n) placeholder expects numeric value, " . gettype($value) . " given");
        }
    }

    /**
     * Method to escape string before binding it into query string.
     *
     * @param string $value String to escape.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return float Escaped string.
     */
    public function escapeString($value)
    {
        if (isset($value)) {
            return $this->quote($value);
        } else {
            throw new SafeSQLException('007', "Empty value for string (?s) placeholder");
        }
    }

    /**
     * Method to escape identifier before binding it into query string.
     *
     * @param string $value Identifier to escape.
     *
     * @throws SafeSQLException SafeSQLException instance.
     * @return string Escaped identifier.
     */
    public function escapeIdentifier($value = null)
    {
        if (isset($value)) {
            return "`".str_replace("`", "``", $value)."`";
        } else {
            throw new SafeSQLException('008', "Empty value for identifier (?i) placeholder");
        }
    }
}













