<?php
/**
 * File /Framework/QueryBuilderException.php contains the QueryBuilder class
 * which is a helper class to build sql requests.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\QueryBuilderException;
use Framework\Validator;

/**
 * Class QueryBuilder is used to build safe sql request with placeholders.
 *
 * Class provides methods which help building safe sql request with placeholders.
 *
 * Note: raw query is query with placeholders.
 *
 * Placeholder types:
 *     - ?i - table or column identifiers;
 *     - ?s - string;
 *     - ?n - number.
 *
 * $qb = new QueryBuilder();
 *
 * Examples of safe sql request:
 *
 *     - $qb->createRawQuery('queryName1');
 *       $qb->select('*', 'users')->where('id', '>', 2);
 *       $qb->rawQueries['queryName1']['bindParameters'] == { 'users', 'id', 2 };
 *       $qb->rawQueries['queryName1']['rawQuery'] == "SELECT * FROM ?i WHERE ?i > ?n";
 *
 *     - $qb->createRawQuery('queryName2');
 *       $qb->select(array('id', 'name', 'pass'), 'users'));
 *       $qb->where()->between('id', 2, 10)->orderBy('id')->order("ASC");
 *       $qb->rawQueries['queryName2']['bindParameters'] == { 'id', 'name', 'pass', 'users', 'id', 2, 10, 'id' };
 *       $qb->rawQueries['queryName2']['rawQuery'] == "SELECT ?i, ?i, ?i FROM ?i WHERE ?i BETWEEN ?n AND ?n ORDER BY ?i ASC";
 *
 *     - $qb->createRawQuery('queryName3');
 *       $qb->select('*', 'users')->where('id', '>', 5)->addAND('name', '=', 'igor');
 *       $qb->rawQueries['queryName3']['bindParameters'] == { 'users', 'id', 5, 'name', 'igor' };
 *       $qb->rawQueries['queryName3']['rawQuery'] == "SELECT * FROM ?i WHERE ?i > ?n AND ?i = ?s";
 *
 *     - $qb->createRawQuery('queryName4');
 *       $qb->insert('users', array('id' => 1, 'name' => 'igor', 'pass' => '*****'));
 *       $qb->rawQueries['queryName4']['bindParameters'] == { 'users', 'id', 'name', 'pass', 1, 'igor', '*****' };
 *       $qb->rawQueries['queryName4']['rawQuery'] == "INSERT INTO ?i (?i,?i,?i) VALUES (?n,?s,?s)";
 *
 *     - $qb->createRawQuery('queryName5');
 *       $qb->update('users', array('name' => 'mike', 'pass' => '*******'))->where('id', '=', '3');
 *       $qb->rawQueries['queryName5']['bindParameters'] == { 'users', 'name', 'mike', 'pass', '*******', 'id', 3 };
 *       $qb->rawQueries['queryName5']['rawQuery'] == "UPDATE ?i SET ?i = ?s, ?i = ?s WHERE ?i = ?n";
 *
 *     - $qb->createRawQuery('queryName6');
 *       $qb->delete('users');
 *       $qb->rawQueries['queryName6']['bindParameters'] == { 'users' };
 *       $qb->rawQueries['queryName6']['rawQuery'] == "DELETE FROM ?i";
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class QueryBuilder
{
    /**
     * @static
     * @var array $allowedOperations Available operations in sql request
     */
    public static $allowedOperations = array('<', '>', '<=', '>=', '=', '<>');

    /**
     * @var array $rawQueries Array for holding raw queries
     *                        $rawQueries['rawQuery']       - raw query string;
     *                        $rawQueries['bindParameters'] - parameters for raw query.
     */
    private $rawQueries = array();

    /**
     * @var string $rawQueryString Name of current raw query.
     */
    private $currentRawQuery = "";

    /**
     * Method which stars creating raw query
     *
     * @param $name
     *
     * @throws QueryBuilderException
     * @return $this
     */
    public function createRawQuery($name) {
        if (!is_string($name)) {
            throw new QueryBuilderException("001", "Query name must be string.");
        } else {
            $this->rawQueries[$name]['rawQuery'] = "";
            $this->rawQueries[$name]['bindParameters'] = array();
            $this->currentRawQuery = $name;
            return $this;
        }
    }

    /**
     * Method to get bind parameters of current raw query.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return array Parameters of current raw query to replace placeholders
     *               in sql request.
     */
    public function getBindParameters()
    {
        if (isset($this->currentRawQuery)) {
            return $this->rawQueries[$this->currentRawQuery]['bindParameters'];
        } else {
            throw new QueryBuilderException("001", "Raw query is not specified.");
        }
    }

    /**
     * Method to get all raw queries.
     *
     * @return array Array of raw queries.
     */
    public function getAllRawQueries() {
        return $this->rawQueries;
    }

    /**
     * Method to get current raw query string.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return string Current raw query string with placeholders.
     */
    public function getRawQuery()
    {
        if (isset($this->currentRawQuery)) {
            return $this->rawQueries[$this->currentRawQuery]['rawQuery'];
        } else {
            throw new QueryBuilderException("001", "Raw query is not specified.");
        }
    }

    /**
     * @param $name
     *
     * @throws QueryBuilderException
     * @return $this
     */
    public function chooseRawQuery($name) {
        if (!is_string($name)) {
            throw new QueryBuilderException("003", "Wrong parameter type, must by string.");
        } elseif (!Validator::inList($name, array_keys($this->rawQueries))) {
            throw new QueryBuilderException("004", "There's no query with name '$name'.");
        } else {
            $this->currentRawQuery = $name;
            return $this;
        }
    }

    /**
     * @throws QueryBuilderException
     */
    public function removeRawQuery() {
        if (isset($this->currentRawQuery)) {
            $this->rawQueries[$this->currentRawQuery] = null;
            $this->currentRawQuery = null;
            return $this;
        } else {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        }
    }

    /**
     * Method to make select request.
     *
     * @param string|array $columns   Columns to select.
     * @param string       $tableName Table to select from.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function select($columns = '*', $tableName)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } elseif (is_array($columns) && empty($columns) || $columns === '*') {
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] = "SELECT * FROM ?i";
            $this->rawQueries[$this->currentRawQuery]['bindParameters'] = array($tableName);
            return $this;
        } else {
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] = "SELECT ";
            $this->rawQueries[$this->currentRawQuery]['bindParameters'] = $columns;
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $tableName;
            $numOfColumns = count($columns);
            $comma = "";
            for ($i = 0;$i < $numOfColumns;$i++) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= $comma."?i";
                $comma = ", ";
            }
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " FROM ?i";
            return $this;
        }
    }

    /**
     * Method to make insert request.
     *
     * @param string $tableName Table to insert to.
     * @param array  $pairs     Data to insert where keys are column names
     *                          and values are values to insert.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function insert($tableName, $pairs)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'] = array($tableName);
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] = "INSERT INTO ?i ";
            $this->rawQueries[$this->currentRawQuery]['bindParameters']
                = array_merge($this->rawQueries[$this->currentRawQuery]['bindParameters'], array_keys($pairs), array_values($pairs));
            $comma = $columns = $values = "";
            foreach ($pairs as $value) {
                $columns .= $comma."?i";
                if (is_float($value) || is_integer($value)) {
                    $values .= $comma."?n";
                } elseif (is_string($value)) {
                    $values .= $comma."?s";
                }
                $comma = ", ";
            }
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= "($columns) VALUES ($values)";
            return $this;
        }
    }

    /**
     * Method to make update request.
     *
     * @param string $tableName Table to update data of.
     * @param array  $pairs     Data to update where keys are column names
     *                          and values are new values.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function update($tableName, $pairs)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'] = array($tableName);
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] = "UPDATE ?i SET ";
            foreach ($pairs as $column => $value) {
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $column;
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $value;
            }
            $comma = "";
            foreach ($pairs as $value) {
                if (is_float($value) || is_integer($value)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= $comma."?i = ?n";
                } elseif (is_string($value)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= $comma."?i = ?s";
                }
                $comma = ", ";
            }
            return $this;
        }
    }

    /**
     * Method to make delete request.
     *
     * @param string $tableName Table to delete from.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function delete($tableName)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'] = array($tableName);
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] = "DELETE FROM ?i";
            return $this;
        }
    }

    /**
     * Method to make 'where' part of sql request.
     *
     * @param null|string $columnName  Column name.
     * @param null|string $operator    Operator.
     * @param mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return QueryBuilder QueryBuilder object.
     */
    public function where($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " WHERE ";
                return $this;
            }

            if (Validator::inList($operator, self::$allowedOperations)) {
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " WHERE ?i $operator ?n";
                } elseif (is_string($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " WHERE ?i $operator ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
            }
        }
    }

    /**
     * Method to add 'OR' operator to sql request.
     *
     * @param null|string $columnName  Column name.
     * @param null|string $operator    Operator.
     * @param mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return QueryBuilder QueryBuilder object.
     */
    public function addOR($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " OR ";
                return $this;
            }

            if (in_array($operator, self::$allowedOperations)) {
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " OR ?i $operator ?n";
                } elseif (is_string($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " OR ?i $operator ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
            }
        }
    }

    /**
     * Method to add 'AND' operator.
     *
     * @param null|string $columnName  Column name.
     * @param null|string $operator    Operator.
     * @param mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return QueryBuilder QueryBuilder object.
     */
    public function addAND($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " AND ";
                return $this;
            }

            if (in_array($operator, self::$allowedOperations)) {
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
                $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " AND ?i = ?n";
                } elseif (is_string($columnValue)) {
                    $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " AND ?i = ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
            }
        }
    }

    /**
     * Method to add 'IS NULL' operator or 'IS NOT NULL' when $not == true.
     *
     * @param string $columnName Column name.
     * @param bool   $not        Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return QueryBuilder QueryBuilder object.
     */
    public function isNULL($columnName, $not = false)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } elseif (isset($columnName)) {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
            if ($not === true) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i IS NOT NULL ";
            } else {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i IS NULL ";
            }
            return $this;
        } else {
            throw new QueryBuilderException('002', "column has not been specified for 'IS NULL' operator");
        }
    }

    /**
     * Method to add 'BETWEEN' operator or 'NOT BETWEEN' when $not === true.
     *
     * @param string $columnName Column name.
     * @param mixed  $begin      Start value.
     * @param mixed  $end        End value.
     * @param bool   $not        Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     * @return QueryBuilder QueryBuilder object.
     */
    public function between($columnName, $begin, $end, $not = false)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } elseif (isset($columnName) && isset($begin) && isset($end)) {
            $not = ($not === true)?"NOT":"";
            if (is_string($begin)) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i $not BETWEEN ?s AND ?s ";
            } elseif (is_float($begin) || is_integer($begin)) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i $not BETWEEN ?n AND ?n ";
            }
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $begin;
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $end;
            return $this;
        } else {
            throw new QueryBuilderException(
                '003',
                "Column name or correct range values has not been specified for 'BETWEEN' operator"
            );
        }
    }

    /**
     * Method to make 'GROUP BY' request.
     *
     * @param string $groupBy Column name to group by.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function groupBy($groupBy)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $groupBy;
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " GROUP BY ?i ";
            return $this;
        }
    }

    /**
     * Method to make 'LIKE' request or 'NOT LIKE' if $not === true.
     *
     * @param string $columnName  Column name.
     * @param mixed  $columnValue Column value.
     * @param bool   $not         Inversion.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function like($columnName, $columnValue, $not = false)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnValue;
            if ($not === true) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i NOT LIKE ?s ";
            } else {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i LIKE ?s ";
            }
            return $this;
        }
    }

    /**
     * Method to make 'IN' operator or 'NOT IN' if $not === true
     *
     * @param string $columnName Column name.
     * @param array  $in         Array of values for 'IN' operator.
     * @param bool   $not        Inversion.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function in($columnName, $in, $not = false)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $columnName;
            $this->rawQueries[$this->currentRawQuery]['bindParameters']
                                                                          = array_merge($this->rawQueries[$this->currentRawQuery]['bindParameters'], $in);
            if ($not === true) {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i NOT IN ";
            } else {
                $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ?i IN ";
            }

            $comma = $values = "";
            foreach ($in as $value) {
                if (is_float($value) || is_integer($value)) {
                    $values .= $comma."?n";
                } elseif (is_string($value)) {
                    $values .= $comma."?s";
                }
                $comma = ", ";
            }
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= "($values)";
            return $this;
        }
    }

    /**
     * Method to add 'ORDER BY' operator.
     *
     * @param string $orderBy Column name to order by.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function orderBy($orderBy)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $orderBy;
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " ORDER BY ?i";
            return $this;
        }
    }

    /**
     * Method to choose order for 'ORDER BY' operator.
     *
     * @param string $order Order type ('ASC', 'DESC').
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function order($order = "DESC")
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } elseif ($order !== "DESC" && $order !== "ASC") {
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " DESC";
            return $this;
        } else {
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " $order";
            return $this;
        }
    }

    /**
     * Method to specify 'LIMIT' for 'SELECT' or 'UPDATE' operators.
     * If $limit isn't specified amount of records to select or update will be unlimited.
     *
     * @param null|int $limit Maximum amount of records to select or update.
     *
     * @throws QueryBuilderException
     * @return QueryBuilder QueryBuilder object.
     */
    public function limit($limit)
    {
        if (!isset($this->currentRawQuery)) {
            throw new QueryBuilderException("005", "Raw query is not chosen.");
        } elseif (!isset($limit)) {
            throw new QueryBuilderException("006", "Limit is not specified.");
        } else {
            $this->rawQueries[$this->currentRawQuery]['bindParameters'][] = $limit;
            $this->rawQueries[$this->currentRawQuery]['rawQuery'] .= " LIMIT ?n";
            return $this;
        }
    }
}