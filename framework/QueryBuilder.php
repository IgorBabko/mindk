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

/**
 * Class QueryBuilder is used to build safe sql request with placeholders.
 *
 * Class provides methods which help building safe sql request with placeholders.
 * Placeholder types:
 *     - ?i - table or column identifiers;
 *     - ?s - string;
 *     - ?n - number.
 *
 * $qb = new QueryBuilder();
 *
 * Examples of safe sql request:
 *
 *     - $qb->select('*', 'users')->where('id', '>', 2);
 *       $qb->bindParameters == { 'users', 'id', 2 };
 *       $qb->rawQueryString == "SELECT * FROM ?i WHERE ?i > ?n";
 *
 *     - $qb->select(array('id', 'name', 'pass'), 'users');
 *       $qb->where()->between('id', 2, 10)->orderBy('id')->order("ASC");
 *       $qb->bindParameters == { 'id', 'name', 'pass', 'users', 'id', 2, 10, 'id' };
 *       $qb->rawQueryString == "SELECT ?i, ?i, ?i FROM ?i WHERE ?i BETWEEN ?n AND ?n ORDER BY ?i ASC";
 *
 *     - $qb->select('*', 'users')->where('id', '>', 5)->addAND('name', '=', 'igor');
 *       $qb->bindParameters == { 'users', 'id', 5, 'name', 'igor' };
 *       $qb->rawQueryString == "SELECT * FROM ?i WHERE ?i > ?n AND ?i = ?s";
 *
 *     - $qb->insert('users', array('id' => 1, 'name' => 'igor', 'pass' => '*****'));
 *       $qb->bindParameters == { 'users', 'id', 'name', 'pass', 1, 'igor', '*****' };
 *       $qb->rawQueryString == "INSERT INTO ?i (?i,?i,?i) VALUES (?n,?s,?s)";
 *
 *     - $qb->update('users', array('name' => 'mike', 'pass' => '*******'))->where('id', '=', '3');
 *       $qb->bindParameters == { 'users', 'name', 'mike', 'pass', '*******', 'id', 3 };
 *       $qb->rawQueryString == "UPDATE ?i SET ?i = ?s, ?i = ?s WHERE ?i = ?n";
 *
 *     - $qb->delete('users');
 *       $qb->bindParameters == { 'users' };
 *       $qb->rawQueryString == "DELETE FROM ?i";
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
     * @var array $bindParameters Parameters to replace placeholders in sql request
     */
    private $bindParameters = array();

    /**
     * @var string $rawQueryString Query string with placeholders
     */
    private $rawQueryString = "";

    /**
     * Method to get bind parameters.
     *
     * @return array Parameters to replace placeholders in sql request.
     */
    public function getBindParameters()
    {
        return $this->bindParameters;
    }

    /**
     * Method to get query string with placeholders.
     *
     * @return string Query string with placeholders.
     */
    public function getRawQueryString()
    {
        return $this->rawQueryString;
    }

    /**
     * Method to make select request.
     *
     * @param string|array $columns   Columns to select.
     * @param string       $tableName Table to select from.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function select($columns = '*', $tableName)
    {
        if (is_array($columns) && empty($columns) || $columns === '*') {
            $this->rawQueryString = "SELECT * FROM ?i";
            $this->bindParameters = array($tableName);
        } else {
            $this->rawQueryString   = "SELECT ";
            $this->bindParameters   = $columns;
            $this->bindParameters[] = $tableName;
            $numOfColumns           = count($columns);
            $comma                  = "";
            for ($i = 0;$i < $numOfColumns;$i++) {
                $this->rawQueryString .= $comma."?i";
                $comma = ", ";
            }

            $this->rawQueryString .= " FROM ?i";
        }
        return $this;
    }

    /**
     * Method to make insert request.
     *
     * @param string $tableName Table to insert to.
     * @param array $pairs Data to insert where keys are column names
     *                     and values are values to insert.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function insert($tableName, $pairs)
    {
        $this->bindParameters = array($tableName);
        $this->rawQueryString = "INSERT INTO ?i ";
        $this->bindParameters = array_merge($this->bindParameters, array_keys($pairs), array_values($pairs));
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
        $this->rawQueryString .= "($columns) VALUES ($values)";
        return $this;
    }

    /**
     * Method to make update request.
     *
     * @param string $tableName Table to update data of.
     * @param array  $pairs     Data to update where keys are column names
     *                          and values are new values.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function update($tableName, $pairs)
    {
        $this->bindParameters = array($tableName);
        $this->rawQueryString = "UPDATE ?i SET ";
        foreach ($pairs as $column => $value) {
            $this->bindParameters[] = $column;
            $this->bindParameters[] = $value;
        }
        $comma = "";
        foreach ($pairs as $value) {
            if (is_float($value) || is_integer($value)) {
                $this->rawQueryString .= $comma."?i = ?n";
            } elseif (is_string($value)) {
                $this->rawQueryString .= $comma."?i = ?s";
            }
            $comma = ", ";
        }
        return $this;
    }

    /**
     * Method to make delete request.
     *
     * @param string $tableName Table to delete from.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function delete($tableName)
    {
        $this->bindParameters = array($tableName);
        $this->rawQueryString = "DELETE FROM ?i";
        return $this;
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
        if (!isset($columnName)) {
            $this->rawQueryString .= " WHERE ";
            return $this;
        }

        if (in_array($operator, self::$allowedOperations)) {
            $this->bindParameters[] = $columnName;
            $this->bindParameters[] = $columnValue;
            if (is_float($columnValue) || is_integer($columnValue)) {
                $this->rawQueryString .= " WHERE ?i $operator ?n";
            } elseif (is_string($columnValue)) {
                $this->rawQueryString .= " WHERE ?i $operator ?s";
            }
            return $this;
        } else {
            throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
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
        if (!isset($columnName)) {
            $this->rawQueryString .= " OR ";
            return $this;
        }

        if (in_array($operator, self::$allowedOperations)) {
            $this->bindParameters[] = $columnName;
            $this->bindParameters[] = $columnValue;
            if (is_float($columnValue) || is_integer($columnValue)) {
                $this->rawQueryString .= " OR ?i $operator ?n";
            } elseif (is_string($columnValue)) {
                $this->rawQueryString .= " OR ?i $operator ?s";
            }
            return $this;
        } else {
            throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
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
        if (!isset($columnName)) {
            $this->rawQueryString .= " AND ";
            return $this;
        }

        if (in_array($operator, self::allowedOperations)) {
            $this->bindParameters[] = $columnName;
            $this->bindParameters[] = $columnValue;
            if (is_float($columnValue) || is_integer($columnValue)) {
                $this->rawQueryString .= " AND ?i = ?n";
            } elseif (is_string($columnValue)) {
                $this->rawQueryString .= " AND ?i = ?s";
            }
            return $this;
        } else {
            throw new QueryBuilderException('001', "wrong operator '$operator' was used in sql request");
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
        if (isset($columnName)) {
            $this->bindParameters[] = $columnName;
            if ($not === true) {
                $this->rawQueryString .= " ?i IS NOT NULL ";
            } else {
                $this->rawQueryString .= " ?i IS NULL ";
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
        $not = ($not === true)?"NOT":"";
        if (isset($columnName) && isset($begin) && isset($end)) {
            if (is_string($begin)) {
                $this->rawQueryString .= " ?i $not BETWEEN ?s AND ?s ";
            } elseif (is_float($begin) || is_integer($begin)) {
                $this->rawQueryString .= " ?i $not BETWEEN ?n AND ?n ";
            }
            $this->bindParameters[] = $columnName;
            $this->bindParameters[] = $begin;
            $this->bindParameters[] = $end;
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
     * @return QueryBuilder QueryBuilder object.
     */
    public function groupBy($groupBy)
    {
        $this->bindParameters[] = $groupBy;
        $this->rawQueryString .= " GROUP BY ?i ";
        return $this;
    }

    /**
     * Method to make 'LIKE' request or 'NOT LIKE' if $not === true.
     *
     * @param string $columnName  Column name.
     * @param mixed  $columnValue Column value.
     * @param bool   $not         Inversion.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function like($columnName, $columnValue, $not = false)
    {
        $this->bindParameters[] = $columnName;
        $this->bindParameters[] = $columnValue;
        if ($not === true) {
            $this->rawQueryString .= " ?i NOT LIKE ?s ";
        } else {
            $this->rawQueryString .= " ?i LIKE ?s ";
        }
        return $this;
    }

    /**
     * Method to make 'IN' operator or 'NOT IN' if $not === true
     *
     * @param string $columnName Column name.
     * @param array  $in         Array of values for 'IN' operator.
     * @param bool   $not        Inversion.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function in($columnName, $in, $not = false)
    {
        $this->bindParameters[] = $columnName;
        $this->bindParameters   = array_merge($this->bindParameters, $in);
        if ($not === true) {
            $this->rawQueryString .= " ?i NOT IN ";
        } else {
            $this->rawQueryString .= " ?i IN ";
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
        $this->rawQueryString .= "($values)";
        return $this;
    }

    /**
     * Method to add 'ORDER BY' operator.
     *
     * @param string $orderBy Column name to order by.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function orderBy($orderBy)
    {
        $this->bindParameters[] = $orderBy;
        $this->rawQueryString .= " ORDER BY ?i";
        return $this;
    }

    /**
     * Method to choose order for 'ORDER BY' operator.
     *
     * @param string $order Order type ('ASC', 'DESC').
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function order($order = "DESC")
    {
        if ($order !== "DESC" && $order !== "ASC") {
            $this->rawQueryString .= " DESC";
        } else {
            $this->rawQueryString .= " $order";
        }
        return $this;
    }

    /**
     * Method to specify 'LIMIT' for 'SELECT' or 'UPDATE' operators.
     * If $limit isn't specified amount of records to select or update will be unlimited.
     *
     * @param null|int $limit Maximum amount of records to select or update.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public function limit($limit = null)
    {
        if (isset($limit)) {
            $this->bindParameters[] = $limit;
            $this->rawQueryString .= " LIMIT ?n";
        }
        return $this;
    }
}