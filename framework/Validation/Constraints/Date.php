<?php
/**
 * File /framework/Validation/Constraints/Date.php contains Date constraint class
 * to validate date.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Date class is used to validate date.
 * User can specify pattern which must be used for validation.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Date extends Constraint
{

    /**
     * @var null|string Pattern for validation
     */
    private $pattern;

    /**
     * Date constructor takes pattern (optional parameter) and error message.
     *
     * @param null   $pattern Pattern for validation.
     * @param string $message Error message.
     *
     * @return Date Date object.
     */
    public function __construct($pattern = null, $message = null)
    {
        $this->pattern = empty($pattern)?"/^([012]\\d|3[01])\\.(0\\d|1[012])\\.20\\d\\d$/":$pattern;
        $message = isset($message) ? $message : "must be date in a right format";
        parent::__construct($message);
    }

    /**
     * Method to validate date.
     *
     * @param  string $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is data valid or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (preg_match($this->pattern, $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for Date::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}