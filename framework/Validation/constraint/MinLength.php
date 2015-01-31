<?php
/**
 * File /framework/validation/constraint/MinLength.php contains MinLength constraint class
 * to check whether length of current string is not less than min length.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * MinLength class is used to check whether length of current string is not less than min length.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MinLength extends Constraint
{
    /**
     * @var int $_min Min allowed length
     */
    private $_min;

    /**
     * MinLength constructor takes min length and error message.
     *
     * @param int $min Min allowed length.
     * @param null|string $message Error message.
     *
     * @return object MinLength.
     */
    public function __construct($min, $message = null)
    {
        $this->_min = $min;
        $message = isset($message) ? $message : "length must be at least $min character(s)";
        parent::__construct($message);
    }

    /**
     * Method to get min value.
     *
     * @return int Min value.
     */
    public function getMin()
    {
        return $this->_min;
    }

    /**
     * Method to set min value.
     *
     * @param  int $min Min value to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setMax($min)
    {
        if (is_int($min)) {
            $this->_min = $min;
        } else {
            $parameterType = gettype($min);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for MaxLength::setMin method must be 'int', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to check whether length of current string is not less than min length.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Isn't length of current string less than min length?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (strlen($value) >= $this->_min) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for MinLength::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}