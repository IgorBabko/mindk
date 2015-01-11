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

//    /**
//     * Method to set table name that current ActiveRecord class will represent.
//     *
//     * @param  string $tableName Table name to set.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return ActiveRecord ActiveRecord object.
//     */
//    public function setTable($tableName);

//    /**
//     * Method to get model name.
//     *
//     * @return string models name.
//     */
//    public function getModel();
//
//    /**
//     * Method to set model name.
//     *
//     * @param  string $modelName models name to set.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return ActiveRecord ActiveRecord object.
//     */
//    public function setModel($modelName);

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

//    /**
//     * Method to set validation constraints for current model.
//     *
//     * @param  string $fieldName   Field name to set constraints for.
//     * @param  array  $constraints validation constraints.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return void
//     */
//    public function setConstraints($fieldName, $constraints);
//
//    /**
//     * Method to get validation constraints of current model.
//     *
//                                                  * @param  string $fieldName Field name which to get constraints for.
    /**
     * Method to get validation constraints for current model.
     *
     * @return array  Validation constraints.
     */
    public static function getConstraints();
//
//    /**
//     * Method to add validation constraint for current model.
//     *
//     * @param  string     $fieldName  Field name to add constraint for.
//     * @param  Constraint $constraint validation constraint.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return void
//     */
//    public function addConstraint($fieldName, Constraint $constraint);
//
//    /**
//     * Method to set sanitization filters for current model.
//     *
//     * @param  string $fieldName Field name to set filters for.
//     * @param  array  $filters   sanitization filters.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return void
//     */
//    public function setFilters($fieldName, $filters);
//
//    /**
//     * Method to get sanitization filters of current model.
//     *
//                                                 * @param  string $fieldName Field name which to get filters for.
    /**
     * Method to set sanitization filters for current model.
     *
     * @return array Sanitization filters.
     */
    public static function getFilters();
//
//    /**
//     * Method to add sanitization filter for current model.
//     *
//     * @param  string $fieldName Field name to add filter for.
//     * @param  Filter $filter    sanitization filter.
//     *
//     * @throws \Framework\Exception\ActiveRecordException ActiveRecordException instance.
//     *
//     * @return void
//     */
//    public function addFilter($fieldName, Filter $filter);
}