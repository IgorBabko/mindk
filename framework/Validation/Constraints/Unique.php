<?php
/**
 * File /framework/Validation/Constraints/Unique.php contains Unique constraint class
 * to check whether value is unique.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Unique class is used to check whether value is unique.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Unique extends Constraint
{
    /**
     * @var string $tableName Table name where field to check must be taken from
     */
    private $tableName;

    /**
     * @var string $fieldName Field name where values to check must be taken from
     */
    private $fieldName;

    /**
     * Unique constructor takes table name, field name and error message.
     *
     * @param string        $tableName Table name.
     * @param string        $fieldName Field name.
     * @param null|string   $message   Error message.
     *
     * @return Unique Unique object.
     */
    public function __construct($tableName, $fieldName, $message = null)
    {
        $this->tableName = $tableName;
        $this->fieldName = $fieldName;
        $message         = isset($message)?$message:"already exists";
        parent::__construct($message);
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
            if (is_int($value) || is_float($value) || is_string($value)) {
                $rawQuery = is_string(
                    $value
                )?$rawQuery = "SELECT ?i FROM ?i WHERE ?i = ?s":"SELECT ?i FROM ?i WHERE ?i = ?n";
                $bindParameters = array('id', $this->tableName, $this->fieldName, $value);
                $resultSet = Application::$dbConnection->safeQuery($rawQuery, $bindParameters);
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