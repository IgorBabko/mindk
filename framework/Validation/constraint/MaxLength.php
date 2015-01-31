<?php
/**
 * File /framework/validation/constraint/MaxLength.php contains MaxLength constraint class
 * to check whether length of current string is no more than max length.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * MaxLength class is used to check whether length of current string is no more than max length.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MaxLength extends Constraint
{
    /**
     * @var int $_max Max allowed length
     */
    private $_max;

    /**
     * MaxLength constructor takes max length and error message.
     *
     * @param  int $max Max allowed length.
     * @param  null|string $message Error message.
     *
     * @return object MaxLength.
     */
    public function __construct($max, $message = null)
    {
        $this->_max = $max;
        $message = isset($message) ? $message : "length must be no more than $max character(s)";
        parent::__construct($message);
    }

    /**
     * Method to get max value.
     *
     * @return int Max value.
     */
    public function getMax()
    {
        return $this->_max;
    }

    /**
     * Method to set max value.
     *
     * @param  int $max Max value to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setMax($max)
    {
        if (is_int($max)) {
            $this->_max = $max;
        } else {
            $parameterType = gettype($max);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for MaxLength::setMax method must be 'int', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to check whether length of current string is no more than max length.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is length of current value no more than max length?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (strlen($value) <= $this->_max) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for MaxLength::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}