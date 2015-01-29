<?php
/**
 * File /framework/validation/constraint/Email.php contains Email constraint class
 * to validate email.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Email class is used to validate email.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Email extends Constraint
{
    /**
     * Email constructor takes error message.
     *
     * @param  string $message Error message.
     *
     * @return object Email.
     */
    public function __construct($message = null)
    {
        $message = isset($message)?$message:"must be email address";
        parent::__construct($message);
    }

    /**
     * Method to validate email.
     *
     * @param  string $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is email valid or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for Email::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}