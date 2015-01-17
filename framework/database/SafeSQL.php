<?php
/**
 * File /framework/database/SafeSql.php contains the SafeSQL class
 * which provides secure interaction with database.
 *
 * PHP version 5
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Database;

use \PDO;
use \PDOStatement;
use Framework\Exception\SafeSQLException;

/**
 * Class SafeSQL is used to make safe sql request to database.
 * It extends Database class.
 * Default implementation of {@link SafeSqlInterface}.
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
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SafeSQL extends Database implements SafeSqlInterface
{
    /**
     * @var null|PDOStatement $_sqlResultSet PDOStatement object which holds data obtained from database
     */
    private $_sqlResultSet = null;

    /**
     * @var null|array $_resultSet Array of data fetched from PDOStatement object
     */
    private $_resultSet = null;

    /**
     * @var null|int $_numOfRows Holds number of rows fetched by the last 'SELECT' request to database
     */
    private $_numOfRows = null;

    /**
     * @var null|int $_numOfColumns Holds number of columns fetched by the last 'SELECT' request to database
     */
    private $_numOfColumns = null;

    /**
     * @var null|integer $_numOfAffectedRows Holds number of rows in database affected by the
     *                                       last 'INSERT', 'UPDATE', OR 'DELETE' requests.
     */
    private $_numOfAffectedRows = null;

    /**
     * SafeSQL constructor establishes connection with database.
     *
     * @param  string $engine  Type of database server (e.g. mysql).
     * @param  string $host    Hostname.
     * @param  string $db      Database name.
     * @param  string $user    Username.
     * @param  string $pass    User password.
     * @param  string $charset Charset.
     *
     * @return SafeSql SafeSql instance.
     */
    public function __construct($user, $pass, $db, $engine = "mysql", $host = "localhost", $charset = "utf8")
    {
        parent::__construct($user, $pass, $db, $engine, $host, $charset);
    }

    /**
     * {@inheritdoc}
     */
    public function getResultSet()
    {
        return $this->_resultSet;
    }

    /**
     * {@inheritdoc}
     */
    public function getSqlResultSet()
    {
        return $this->_sqlResultSet;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumOfAffectedRows()
    {
        return $this->_numOfAffectedRows;
    }


    /**
     * {@inheritdoc}
     */
    public function getNumOfColumns()
    {
        return $this->_numOfColumns;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumOfRows()
    {
        if ($this->_resultSet !== null) {
            return count($this->_resultSet);
        } else {
            throw new SafeSQLException('001', "Can not get number of rows if SafeSQL::_resultSet is undefined");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOne()
    {
        if (isset($this->_resultSet)) {
            return reset($this->_resultSet[0]);
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::_resultSet is undefined");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRow($rowIndex = 1)
    {
        if (isset($this->_resultSet)) {
            if ($this->_numOfRows > $rowIndex && $rowIndex >= 1) {
                return $this->_resultSet[--$rowIndex];
            } else {
                throw new SafeSQLException('003', "specified row index doesn't belong to range [1; SafeSQL::numOfRows]");
            }
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::_resultSet is undefined");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($columnIndex = 1)
    {
        $column = array();
        if (isset($this->_resultSet)) {
            if ($this->_numOfColumns >= $columnIndex && $columnIndex >= 1) {
                foreach ($this->_resultSet as $row) {
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
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::_resultSet is undefined");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        if (isset($this->_resultSet)) {
            return $this->_resultSet;
        } else {
            throw new SafeSQLException('002', "Can not get fetched data if SafeSQL::_resultSet is undefined");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeQuery($rawQueryString, $bindParameters)
    {
        $queryString = $this->prepareQuery($rawQueryString, $bindParameters);
        if (strpos($queryString, "SELECT") !== false) {
            $this->_sqlResultSet = $this->query($queryString);
            if ($this->_sqlResultSet !== false) {
                $this->_resultSet = array();
                while ($row = $this->_sqlResultSet->fetch(PDO::FETCH_ASSOC)) {
                    $this->_resultSet[] = $row;
                }
                $this->_numOfRows = count($this->_resultSet);
                if ($this->_numOfRows === 0) {
                    $this->_numOfColumns = 0;
                } else {
                    foreach ($this->_resultSet as $row) {
                        $this->_numOfColumns = count($row);
                        break;
                    }
                }
                return $this->_resultSet;
            } else {
                throw new SafeSQLException('005', "sql request is failed");
            }
        } else {
            $this->_sqlResultSet = null;
            $this->_resultSet = null;
            $this->_numOfRows = null;
            $this->_numOfColumns = null;
            info($queryString);
            $this->_numOfAffectedRows = $this->exec($queryString);
            if ($this->_numOfAffectedRows === false) {
                $this->_numOfAffectedRows = null;
                throw new SafeSQLException('005', "sql request is failed");
            } else {
                return $this->_numOfAffectedRows;
            }
        }
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
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