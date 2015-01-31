<?php
/**
 * File /framework/validation/constraint/Date.php contains Date constraint class
 * to validate date.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Date class is used to validate date.
 * User can specify pattern which must be used for validation.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Date extends Constraint
{
    /**
     * @var null|string $_pattern Pattern for validation
     */
    private $_pattern;

    /**
     * Date constructor takes pattern (optional parameter) and error message.
     *
     * @param  null|string $pattern Pattern for validation.
     * @param  string $message Error message.
     *
     * @return object Date.
     */
    public function __construct($pattern = null, $message = null)
    {
        $this->_pattern = empty($pattern) ? "/^([012]\d|3[01])\.(0\d|1[012])\.20\d\d$/" : $pattern;
        $message = isset($message) ? $message : "must be date in a right format";
        parent::__construct($message);
    }

    /**
     * Method to get pattern.
     *
     * @return null|string Pattern.
     */
    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * Method to set pattern.
     *
     * @param  string $pattern Pattern to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setPattern($pattern)
    {
        if (is_string($pattern)) {
            $this->_pattern = $pattern;
        } else {
            $parameterType = gettype($pattern);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for Date::setPattern method must be 'string', '$parameterType' is given"
            );
        }
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
            if (preg_match($this->_pattern, $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for Date::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}