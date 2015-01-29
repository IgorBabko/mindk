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

namespace Framework\Util;

use Framework\Exception\QueryBuilderException;
use Framework\Validation\Constraint\InList;
use Framework\Validation\Validator;

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
 *       $qb->_rawQueries['queryName1']['bindParameters'] == { 'users', 'id', 2 };
 *       $qb->_rawQueries['queryName1']['rawQuery'] == "SELECT * FROM ?i WHERE ?i > ?n";
 *
 *     - $qb->createRawQuery('queryName2');
 *       $qb->select(array('id', 'name', 'pass'), 'users'));
 *       $qb->where()->between('id', 2, 10)->orderBy('id')->order("ASC");
 *       $qb->_rawQueries['queryName2']['bindParameters'] == { 'id', 'name', 'pass', 'users', 'id', 2, 10, 'id' };
 *       $qb->_rawQueries['queryName2']['rawQuery'] == "SELECT ?i, ?i, ?i FROM ?i WHERE ?i BETWEEN ?n AND ?n ORDER BY ?i ASC";
 *
 *     - $qb->createRawQuery('queryName3');
 *       $qb->select('*', 'users')->where('id', '>', 5)->addAND('name', '=', 'igor');
 *       $qb->_rawQueries['queryName3']['bindParameters'] == { 'users', 'id', 5, 'name', 'igor' };
 *       $qb->_rawQueries['queryName3']['rawQuery'] == "SELECT * FROM ?i WHERE ?i > ?n AND ?i = ?s";
 *
 *     - $qb->createRawQuery('queryName4');
 *       $qb->insert('users', array('id' => 1, 'name' => 'igor', 'pass' => '*****'));
 *       $qb->_rawQueries['queryName4']['bindParameters'] == { 'users', 'id', 'name', 'pass', 1, 'igor', '*****' };
 *       $qb->_rawQueries['queryName4']['rawQuery'] == "INSERT INTO ?i (?i,?i,?i) VALUES (?n,?s,?s)";
 *
 *     - $qb->createRawQuery('queryName5');
 *       $qb->update('users', array('name' => 'mike', 'pass' => '*******'))->where('id', '=', '3');
 *       $qb->_rawQueries['queryName5']['bindParameters'] == { 'users', 'name', 'mike', 'pass', '*******', 'id', 3 };
 *       $qb->_rawQueries['queryName5']['rawQuery'] == "UPDATE ?i SET ?i = ?s, ?i = ?s WHERE ?i = ?n";
 *
 *     - $qb->createRawQuery('queryName6');
 *       $qb->delete('users');
 *       $qb->_rawQueries['queryName6']['bindParameters'] == { 'users' };
 *       $qb->_rawQueries['queryName6']['rawQuery'] == "DELETE FROM ?i";
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class QueryBuilder
{
    /**
     * @static
     * @var array $_allowedOperations Available operations in sql request
     */
    private static $_allowedOperations = array('<', '>', '<=', '>=', '=', '<>');

    /**
     * @var array $_rawQueries Array for holding raw queries
     *                        $_rawQueries['rawQuery']       - raw query string;
     *                        $_rawQueries['bindParameters'] - parameters for raw query.
     */
    private $_rawQueries = array();

    /**
     * @var string $_currentRawQuery Name of current raw query.
     */
    private $_currentRawQuery = "";

    public static function getAllowedOperations()
    {
        return self::$_allowedOperations;
    }

    public static function setAllowedOperations()
    {
    }

    public function getCurrentRawQuery()
    {
        return $this->_currentRawQuery;
    }

    /**
     * Method which stars creating raw query
     *
     * @param $name
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function createRawQuery($name)
    {
        if (!is_string($name)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> query name must be string.");
        } else {
            $this->_rawQueries[$name]['rawQuery']       = "";
            $this->_rawQueries[$name]['bindParameters'] = array();
            $this->_currentRawQuery                     = $name;
            return $this;
        }
    }

    /**
     * Method to get bind parameters of current raw query.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return array Parameters of current raw query to replace placeholders in sql request.
     */
    public function getBindParameters()
    {
        if (isset($this->_currentRawQuery)) {
            return $this->_rawQueries[$this->_currentRawQuery]['bindParameters'];
        } else {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not specified.");
        }
    }

    /**
     * Method to get all raw queries.
     *
     * @return array Array of raw queries.
     */
    public function getAllRawQueries()
    {
        return $this->_rawQueries;
    }

    /**
     * Method to get current raw query string.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return string Current raw query string with placeholders.
     */
    public function getRawQuery()
    {
        if (isset($this->_currentRawQuery)) {
            return $this->_rawQueries[$this->_currentRawQuery]['rawQuery'];
        } else {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not specified.");
        }
    }

    /**
     * @param  $name
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function chooseRawQuery($name)
    {
        if (!is_string($name)) {
            throw new QueryBuilderException(
                500,
                "<strong>Internal server error:</strong> wrong parameter type, must by string."
            );
        } elseif (!Validator::validateValue($name, new InList(array_keys($this->_rawQueries)))) {
            throw new QueryBuilderException(
                500, "<strong>Internal server error:</strong> there's no query with name '$name'."
            );
        } else {
            $this->_currentRawQuery = $name;
            return $this;
        }
    }

    /**
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function removeRawQuery()
    {
        if (isset($this->_currentRawQuery)) {
            $this->_rawQueries[$this->_currentRawQuery] = null;
            $this->_currentRawQuery                     = null;
            return $this;
        } else {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        }
    }

    /**
     * Method to make select request.
     *
     * @param  string|array $columns   Columns to select.
     * @param  string       $tableName Table to select from.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function select($columns = '*', $tableName)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } elseif (is_array($columns) && empty($columns) || $columns === '*') {
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery']       = "SELECT * FROM ?i";
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'] = array($tableName);
            return $this;
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery']         = "SELECT ";
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters']   = $columns;
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $tableName;
            $numOfColumns                                                   = count($columns);
            $comma                                                          = "";
            for ($i = 0;$i < $numOfColumns;$i++) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= $comma."?i";
                $comma = ", ";
            }
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " FROM ?i";
            return $this;
        }
    }

    /**
     * Method to make insert request.
     *
     * @param  string $tableName Table to insert to.
     * @param  array  $pairs     Data to insert where keys are column names
     *                           and values are values to insert.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function insert($tableName, $pairs)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'] = array($tableName);
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery']       = "INSERT INTO ?i ";
            array_shift($pairs);
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters']
                   = array_merge(
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'],
                array_keys($pairs),
                array_values($pairs)
            );
            $comma = $columns = $values = "";
            foreach ($pairs as $value) {
                $columns .= $comma."?i";
                if (is_float($value) || is_int($value)) {
                    $values .= $comma."?n";
                } elseif (is_string($value)) {
                    $values .= $comma."?s";
                }
                $comma = ", ";
            }
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= "($columns) VALUES ($values)";
            return $this;
        }
    }

    /**
     * Method to make update request.
     *
     * @param  string $tableName Table to update data of.
     * @param  array  $pairs     Data to update where keys are column names
     *                           and values are new values.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function update($tableName, $pairs)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'] = array($tableName);
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery']       = "UPDATE ?i SET ";
            foreach ($pairs as $column => $value) {
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $column;
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $value;
            }
            $comma = "";
            foreach ($pairs as $value) {
                if (is_float($value) || is_integer($value)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= $comma."?i = ?n";
                } elseif (is_string($value)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= $comma."?i = ?s";
                }
                $comma = ", ";
            }
            return $this;
        }
    }

    /**
     * Method to make delete request.
     *
     * @param  string $tableName Table to delete from.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function delete($tableName)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'] = array($tableName);
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery']       = "DELETE FROM ?i";
            return $this;
        }
    }

    /**
     * Method to make 'where' part of sql request.
     *
     * @param  null|string $columnName  Column name.
     * @param  null|string $operator    Operator.
     * @param  mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function where($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " WHERE ";
                return $this;
            }

            if (Validator::validateValue($operator, new InList(self::$_allowedOperations))) {
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " WHERE ?i $operator ?n";
                } elseif (is_string($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " WHERE ?i $operator ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException(
                    500, "<strong>Internal server error:</strong> wrong operator '$operator' was used in sql request"
                );
            }
        }
    }

    /**
     * Method to add 'OR' operator to sql request.
     *
     * @param  null|string $columnName  Column name.
     * @param  null|string $operator    Operator.
     * @param  mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function addOR($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " OR ";
                return $this;
            }

            if (in_array($operator, self::$_allowedOperations)) {
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " OR ?i $operator ?n";
                } elseif (is_string($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " OR ?i $operator ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException(
                    500, "<strong>Internal server error:</strong> wrong operator '$operator' was used in sql request"
                );
            }
        }
    }

    /**
     * Method to add 'AND' operator.
     *
     * @param  null|string $columnName  Column name.
     * @param  null|string $operator    Operator.
     * @param  mixed       $columnValue Column value.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function addAND($columnName = null, $operator = null, $columnValue = null)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            if (!isset($columnName)) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " AND ";
                return $this;
            }

            if (in_array($operator, self::$_allowedOperations)) {
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnValue;
                if (is_float($columnValue) || is_integer($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " AND ?i = ?n";
                } elseif (is_string($columnValue)) {
                    $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " AND ?i = ?s";
                }
                return $this;
            } else {
                throw new QueryBuilderException(
                    500, "<strong>Internal server error:</strong> wrong operator '$operator' was used in sql request"
                );
            }
        }
    }

    /**
     * Method to add 'IS NULL' operator or 'IS NOT NULL' when $not == true.
     *
     * @param  string $columnName Column name.
     * @param  bool   $not        Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function isNULL($columnName, $not = false)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } elseif (isset($columnName)) {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
            if ($not === true) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i IS NOT NULL ";
            } else {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i IS NULL ";
            }
            return $this;
        } else {
            throw new QueryBuilderException(
                500,
                "<strong>Internal server error:</strong> column has not been specified for 'IS NULL' operator"
            );
        }
    }

    /**
     * Method to add 'BETWEEN' operator or 'NOT BETWEEN' when $not === true.
     *
     * @param  string $columnName Column name.
     * @param  mixed  $begin      Start value.
     * @param  mixed  $end        End value.
     * @param  bool   $not        Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function between($columnName, $begin, $end, $not = false)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } elseif (isset($columnName) && isset($begin) && isset($end)) {
            $not = ($not === true)?"NOT":"";
            if (is_string($begin)) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i $not BETWEEN ?s AND ?s ";
            } elseif (is_float($begin) || is_integer($begin)) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i $not BETWEEN ?n AND ?n ";
            }
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $begin;
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $end;
            return $this;
        } else {
            throw new QueryBuilderException(
                500,
                "<strong>Internal server error:</strong> column name or correct range values has not been specified for 'BETWEEN' operator"
            );
        }
    }

    /**
     * Method to make 'GROUP BY' request.
     *
     * @param  string $groupBy Column name to group by.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function groupBy($groupBy)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $groupBy;
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " GROUP BY ?i ";
            return $this;
        }
    }

    /**
     * Method to make 'LIKE' request or 'NOT LIKE' if $not === true.
     *
     * @param  string $columnName  Column name.
     * @param  mixed  $columnValue Column value.
     * @param  bool   $not         Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function like($columnName, $columnValue, $not = false)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnValue;
            if ($not === true) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i NOT LIKE ?s ";
            } else {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i LIKE ?s ";
            }
            return $this;
        }
    }

    /**
     * Method to make 'IN' operator or 'NOT IN' if $not === true
     *
     * @param  string $columnName Column name.
     * @param  array  $in         Array of values for 'IN' operator.
     * @param  bool   $not        Inversion.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function in($columnName, $in, $not = false)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $columnName;
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters']
                                                                            = array_merge(
                $this->_rawQueries[$this->_currentRawQuery]['bindParameters'],
                $in
            );
            if ($not === true) {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i NOT IN ";
            } else {
                $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ?i IN ";
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
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= "($values)";
            return $this;
        }
    }

    /**
     * Method to add 'ORDER BY' operator.
     *
     * @param  string $orderBy Column name to order by.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function orderBy($orderBy)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $orderBy;
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " ORDER BY ?i";
            return $this;
        }
    }

    /**
     * Method to choose order for 'ORDER BY' operator.
     *
     * @param  string $order Order type ('ASC', 'DESC').
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function order($order = "DESC")
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } elseif ($order !== "DESC" && $order !== "ASC") {
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " DESC";
            return $this;
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " $order";
            return $this;
        }
    }

    /**
     * Method to specify 'LIMIT' for 'SELECT' or 'UPDATE' operators.
     * If $limit isn't specified amount of records to select or update will be unlimited.
     *
     * @param  null|int $limit Maximum amount of records to select or update.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function limit($limit)
    {
        if (!isset($this->_currentRawQuery)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> raw query is not chosen.");
        } elseif (!isset($limit)) {
            throw new QueryBuilderException(500, "<strong>Internal server error:</strong> limit is not specified.");
        } else {
            $this->_rawQueries[$this->_currentRawQuery]['bindParameters'][] = $limit;
            $this->_rawQueries[$this->_currentRawQuery]['rawQuery'] .= " LIMIT ?n";
            return $this;
        }
    }
}