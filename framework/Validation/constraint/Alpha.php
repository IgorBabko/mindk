<?php
/**
 * File /framework/validation/constraint/Alpha.php contains Alpha constraint class
 * for alphabetic values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Class Alpha is used to validate alphabetic values.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Alpha extends Constraint
{
    /**
     * Alpha constructor takes message for Alpha constraint error.
     *
     * @param  string $message Error message.
     *
     * @return Alpha Alpha object.
     */
    public function __construct($message = " must be alphabetic")
    {
        parent::__construct($message);
    }

    /**
     * Method to validate $value according to Alpha constraint.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value valid or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (preg_match("/^[a-zA-Z]+$/", $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for Alpha::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}