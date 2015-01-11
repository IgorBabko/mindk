<?php
/**
 * File /framework/database/SafeSqlInterface.php contains SafeSqlInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Database;

/**
 * Interface SafeSqlInterface is used to be implemented by SafeSql class.
 *
 * @api
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface SafeSqlInterface
{
    /**
     * Method to get data taken by last 'SELECT' request.
     *
     * @return array|null Data taken by last 'SELECT' request.
     */
    public function getResultSet();

    /**
     * Method to get sql data represented by PDOStatement taken by last 'SELECT' request.
     *
     * @return \PDOStatement|null PDOStatement data taken by last 'SELECT' request.
     */
    public function getSqlResultSet();

    /**
     * Method to get number of rows in database affected by the
     * last 'INSERT', 'UPDATE', OR 'DELETE' requests.
     *
     * @return int|null Number of affected rows.
     */
    public function getNumOfAffectedRows();

    /**
     * Method to get number of columns fetched by the last 'SELECT' request to database.
     *
     * @return int|null Number of columns.
     */
    public function getNumOfColumns();

    /**
     * Method to get number of rows fetched by the last 'SELECT' request to database.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return int|null Number of rows.
     */
    public function getNumOfRows();

    /**
     * Method to get first fetched value from sql result set.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return mixed First fetched value from sql result set.
     */
    public function getOne();

    /**
     * Method to get specified row from sql result set.
     *
     * @param  int $rowIndex Index of row to get.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return array Specified row from sql result set.
     */
    public function getRow($rowIndex);

    /**
     * Method to get specified column from sql result set.
     *
     * @param  int $columnIndex Index of column to get.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return array Specified column from sql result set.
     */
    public function getColumn($columnIndex);

    /**
     * Method to get all fetched data from sql result set.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return array Fetched data from sql result set.
     */
    public function getAll();

    /**
     * Method to make safe sql request to database.
     *
     * It returns data fetched from the database if there was 'SELECT' request
     * otherwise count of affected rows is returned.
     * In the case of request failure method throws an error.
     *
     * @param  string $rawQueryString Query string QueryBuilder::rawQueryString with placeholders.
     * @param  array $bindParameters  Parameters QueryBuilder::bindParameters to replace placeholders
     *                               in QueryBuilder::rawQueryString.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException object.
     *
     * @return void|array Array of data fetched from the database if there was 'SELECT' request
     *                    otherwise it returns void.
     */
    public function safeQuery($rawQueryString, $bindParameters);

    /**
     * Method to replace placeholders in QueryBuilder::rawQueryString with its particular
     * QueryBuilder::bindParameters and escape them before replacing.
     *
     * @param  string $rawQueryString Query string QueryBuilder::rawQueryString with placeholders.
     * @param  array  $bindParameters Parameters QueryBuilder::bindParameters to replace placeholders
     *                               in QueryBuilder::rawQueryString.
     *
     * @return string Query string.
     */
    public function prepareQuery($rawQueryString, $bindParameters);

    /**
     * Method to escape number before binding it into query string.
     *
     * @param  mixed $value Number to escape.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     *
     * @return mixed Escaped number.
     */
    public function escapeNumber($value);

    /**
     * Method to escape string before binding it into query string.
     *
     * @param  string $value String to escape.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     * @return float Escaped string.
     */
    public function escapeString($value);

    /**
     * Method to escape identifier before binding it into query string.
     *
     * @param  string $value Identifier to escape.
     *
     * @throws \Framework\Exception\SafeSQLException SafeSQLException instance.
     * @return string Escaped identifier.
     */
    public function escapeIdentifier($value);
}