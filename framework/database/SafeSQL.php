<?php
/**
 * File /framework/database/SafeSql.php contains the SafeSql class
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
use Framework\Exception\SafeSqlException;

/**
 * Class SafeSql is used to make safe sql request to database.
 * It extends Database class.
 * Default implementation of {@link SafeSqlInterface}.
 *
 * Class uses QueryBuilder::rawQueryString and QueryBuilder::bindParameters to
 * to bind parameters instead of placeholders in QueryBuilder::rawQueryString
 * filtering them in appropriate way before binding.
 *
 * Placeholder types and filter methods associated with them:
 *     - ?i => SafeSql::escapeIdentifier;
 *     - ?n => SafeSql::escapeNumber;
 *     - ?s => SafeSql::escapeString.
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SafeSql extends Database implements SafeSqlInterface
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
     * SafeSql constructor establishes connection with database.
     *
     * @param  string $engine Type of database server (e.g. mysql).
     * @param  string $host Hostname.
     * @param  string $db Database name.
     * @param  string $user Username.
     * @param  string $pass User password.
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> can not get number of rows if SafeSql::_resultSet is undefined"
            );
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> can not get fetched data if SafeSql::_resultSet is undefined"
            );
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
                throw new SafeSqlException(
                    500,
                    "<strong>Internal server error:</strong> specified row index doesn't belong to range [1; SafeSql::numOfRows]"
                );
            }
        } else {
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> can not get fetched data if SafeSql::_resultSet is undefined"
            );
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
                throw new SafeSqlException(
                    500,
                    "<strong>Internal server error:</strong> specified column index doesn't belong to range [1; SafeSql::numOfColumns]"
                );
            }
        } else {
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> can not get fetched data if SafeSql::_resultSet is undefined"
            );
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> can not get fetched data if SafeSql::_resultSet is undefined"
            );
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
                throw new SafeSqlException(500, "<strong>Internal server error:</strong> sql request is failed");
            }
        } else {
            $this->_sqlResultSet = null;
            $this->_resultSet    = null;
            $this->_numOfRows    = null;
            $this->_numOfColumns = null;
            $this->_numOfAffectedRows = $this->exec($queryString);
            if ($this->_numOfAffectedRows === false) {
                $this->_numOfAffectedRows = null;
                throw new SafeSqlException(500, "<strong>Internal server error:</strong> sql request is failed");
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> empty value for number (?n) placeholder"
            );
        } elseif (is_numeric($value)) {
            if (is_integer($value)) {
                return $value;
            }
            $value = number_format($value, 0, '.', '');
            return $value;
        } else {
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> number (?n) placeholder expects numeric value, ".gettype(
                    $value
                )." given"
            );
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> empty value for string (?s) placeholder"
            );
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
            throw new SafeSqlException(
                500,
                "<strong>Internal server error:</strong> empty value for identifier (?i) placeholder"
            );
        }
    }
}