<?php
/**
 * File /framework/validation/constraint/Float.php contains Float constraint class
 * to validate float values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Float class is used to validate float values.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Float extends Constraint
{
    /**
     * Float constructor takes error message.
     *
     * @param  null|string $message Error message.
     *
     * @return \Framework\Validation\Constraint\Float Float object.
     */
    public function __construct($message = null)
    {
        $message = isset($message)?$message:"must be float";
        parent::__construct($message);
    }

    /**
     * Method to validate float values.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is float or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            if (is_float($value)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> value for Float::validate method is NULL"
            );
        }
    }
}