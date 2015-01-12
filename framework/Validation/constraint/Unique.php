<?php
/**
 * File /framework/validation/constraint/Unique.php contains Unique constraint class
 * to check whether value is unique.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Application\App;
use Framework\Exception\ConstraintException;

/**
 * Unique class is used to check whether value is unique.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Unique extends Constraint
{
    /**
     * @var string $_tableName Table name where field to check must be taken from
     */
    private $_tableName;

    /**
     * @var string $_fieldName Field name where values to check must be taken from
     */
    private $_fieldName;

    /**
     * Unique constructor takes table name, field name and error message.
     *
     * @param  string        $tableName Table name.
     * @param  string        $fieldName Field name.
     * @param  null|string   $message   Error message.
     *
     * @return Unique Unique object.
     */
    public function __construct($tableName, $fieldName, $message = null)
    {
        $this->_tableName = $tableName;
        $this->_fieldName = $fieldName;
        $message          = isset($message)?$message:"already exists";
        parent::__construct($message);
    }

    /**
     * Method to get table name.
     *
     * @return string Table name.
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * Method to set table name.
     *
     * @param  string $tableName Table name.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setTableName($tableName)
    {
        if (is_string($tableName)) {
            $this->_tableName = $tableName;
        } else {
            $parameterType = gettype($tableName);
            throw new ConstraintException(
                "001", "Value for Unique::setTableName method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to get field name.
     *
     * @return string Field name.
     */
    public function getFieldName()
    {
        return $this->_fieldName;
    }

    /**
     * Method to set field name.
     *
     * @param  string $fieldName Field name.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setFieldName($fieldName)
    {
        if (is_string($fieldName)) {
            $this->_fieldName = $fieldName;
        } else {
            $parameterType = gettype($fieldName);
            throw new ConstraintException(
                "001", "Value for Unique::setFieldName method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to check whether value is unique
     * by taking set of unique values from specified field of specified table.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value unique or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            info($value);
            if (is_int($value) || is_float($value) || is_string($value)) {
                $rawQuery = is_string($value) ? $rawQuery = "SELECT ?i FROM ?i WHERE ?i = ?s" : "SELECT ?i FROM ?i WHERE ?i = ?n";
                $bindParameters = array('id', $this->_tableName, $this->_fieldName, $value);
                $resultSet = App::getDbConnection()->safeQuery($rawQuery, $bindParameters);
                if (empty($resultSet)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $parameterType = gettype($value);
                throw new ConstraintException(
                    "001", "Value for Unique::validate method must be 'string' || 'int' || 'float', '$parameterType' is given"
                );
            }
        } else {
            throw new ConstraintException("001", "Value for Unique::validate method is NULL");
        }
    }
}