<?php
/**
 * File /framework/validation/constraint/Int.php contains Int constraint class
 * to validate int values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Int class is used to validate int values.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Int extends Constraint
{
    /**
     * Int constructor takes error message.
     *
     * @param  null|string $message Error message.
     *
     * @return \Framework\Validation\Constraint\Int Int object.
     */
    public function __construct($message = null)
    {
        $message = isset($message)?$message:"must be integer";
        parent::__construct($message);
    }

    /**
     * Method to validate int values.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is int or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            if (is_int($value)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> value for Int::validate method is NULL"
            );
        }
    }
}