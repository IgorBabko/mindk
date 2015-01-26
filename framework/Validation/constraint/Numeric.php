<?php
/**
 * File /framework/validation/constraint/Numeric.php contains Numeric constraint class
 * to validate numeric values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Numeric class is used to validate numeric values.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Numeric extends Constraint
{
    /**
     * Numeric constructor takes error message.
     *
     * @param  null|string $message Error message.
     *
     * @return Numeric Numeric object.
     */
    public function __construct($message = null)
    {
        $message = isset($message)?$message:"must be numeric";
        parent::__construct($message);
    }

    /**
     * Method to validate numeric values.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value numeric or not?
     */
    public function validate($value)
    {
        if (!isset($value)) {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> value for Numeric::validate method is NULL"
            );
        } elseif (is_numeric($value)) {
            return true;
        } else {
            return false;
        }
    }
}