<?php
/**
 * File /framework/util/QueryBuilderInterface.php contains
 * QueryBuilderInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

use Framework\Exception\QueryBuilderException;

/**
 * Interface QueryBuilderInterface is used to be implemented by QueryBuilder class.
 *
 * @api
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface QueryBuilderInterface
{
    /**
     * Method to get allowed database operations.
     *
     * @return array Allowed database operations.
     */
    public static function getAllowedOperations();

    /**
     * Method to get current raw query.
     *
     * @return string Current raw query.
     */
    public function getCurrentRawQuery();

    /**
     * Method which stars creating raw query.
     *
     * @param  string $name Name of raw query.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function createRawQuery($name);

    /**
     * Method to get bind parameters of current raw query.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return array Parameters of current raw query to replace placeholders in sql request.
     */
    public function getBindParameters();

    /**
     * Method to get all raw queries.
     *
     * @return array Array of raw queries.
     */
    public function getAllRawQueries();

    /**
     * Method to get current raw query string.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return string Current raw query string with placeholders.
     */
    public function getRawQuery();

    /**
     * Method to choose raw query to work with.
     *
     * @param  string $name Name of the raw query to choose.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function chooseRawQuery($name);

    /**
     * Method to remove current raw query.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function removeRawQuery();

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
    public function select($columns, $tableName);

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
    public function insert($tableName, $pairs);

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
    public function update($tableName, $pairs);

    /**
     * Method to make delete request.
     *
     * @param  string $tableName Table to delete from.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function delete($tableName);

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
    public function where($columnName, $operator, $columnValue);

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
    public function addOR($columnName, $operator, $columnValue);

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
    public function addAND($columnName, $operator, $columnValue);

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
    public function isNULL($columnName, $not);

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
    public function between($columnName, $begin, $end, $not);

    /**
     * Method to make 'GROUP BY' request.
     *
     * @param  string $groupBy Column name to group by.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function groupBy($groupBy);

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
    public function like($columnName, $columnValue, $not);

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
    public function in($columnName, $in, $not);

    /**
     * Method to add 'ORDER BY' operator.
     *
     * @param  string $orderBy Column name to order by.
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function orderBy($orderBy);

    /**
     * Method to choose order for 'ORDER BY' operator.
     *
     * @param  string $order Order type ('ASC', 'DESC').
     *
     * @throws QueryBuilderException QueryBuilderException instance.
     *
     * @return object QueryBuilder.
     */
    public function order($order);

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
    public function limit($limit);
}