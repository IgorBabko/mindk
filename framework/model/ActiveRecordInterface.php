<?php
/**
 * File /framework/model/ActiveRecordInterface.php contains ActiveRecordInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Model
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Model;

use Framework\Database\SafeSQL;
use Framework\Exception\ActiveRecordException;
use Framework\Util\QueryBuilder;

/**
 * Interface ActiveRecordInterface is used to be implemented by ActiveRecord class.
 *
 * @api
 *
 * @package Framework\Model
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ActiveRecordInterface
{
    /**
     * Method to get database connection.
     *
     * @return SafeSQL Database connection.
     */
    public static function getDbConnection();

    /**
     * Method to get query builder.
     *
     * @return QueryBuilder QueryBuilder object.
     */
    public static function getQueryBuilder();

    /**
     * Method to establish connection with database.
     *
     * @param  object $dbConnection Database connection.
     *
     * @throws ActiveRecordException ActiveRecordException instance.
     *
     * @return void
     */
    public static function setDbConnection($dbConnection);

    /**
     * Method to set query builder.
     *
     * @param  QueryBuilder $queryBuilder Query builder.
     *
     * @throws ActiveRecordException ActiveRecordException instance.
     *
     * @return void
     */
    public static function setQueryBuilder($queryBuilder);

    /**
     * Method to make query to database.
     *
     * @param  string $rawQuery Raw query string (with placeholders).
     * @param  string $params   Parameters to replace placeholders in $rawQuery.
     *
     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
     *
     * @return int|array Result set from database or count of affected rows depending on query type.
     */
    public static function query($rawQuery, $params);

    /**
     * Magic setter.
     *
     * @param  string $fieldName Field name to set new value to.
     * @param  mixed  $value     New value to assign.
     *
     * @return void
     */
    public function __set($fieldName, $value);

    /**
     * Magic getter.
     *
     * @param  string $fieldName Field name to get value from.
     *
     * @return mixed
     */
    public function __get($fieldName);

    /**
     * Method to get table name that current ActiveRecord class represents.
     *
     * @return string Table name.
     */
    public static function getTable();

    /**
     * Method loads data from particular record of table ActiveRecord::getTable()
     * to ActiveRecord object depending on $columns array which stands for condition
     * what record must be loaded.
     *
     * @param  array $columns (Columns => Values) Array for query condition to specify record to load.
     *
     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
     *
     * @return ActiveRecord ActiveRecord object.
     */
    public function load($columns);

    /**
     * Method to insert data currently held in ActiveRecord object
     * to ActiveRecord::getTable table or update existing record.
     * $columns array is     empty => insert data.
     * $columns array is not empty => update data.
     *
     * @param  array $columns Array to specify the record which is needed to update.
     *
     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
     *
     * @return ActiveRecord ActiveRecord object.
     */
    public function save($columns);

    /**
     * Method to remove record from ActiveRecord::getTable() table
     * represented by current ActiveRecord object.
     *
     * @return ActiveRecord ActiveRecord object.
     */
    public function remove();

    /**
     * Method to get validation constraints for current model.
     *
     * @param  string $context Validation context.
     *
     * @return array  Validation constraints.
     */
    public static function getConstraints($context);

    /**
     * Method to set sanitization filters for current model.
     *
     * @return array Sanitization filters.
     */
    public static function getFilters();
}