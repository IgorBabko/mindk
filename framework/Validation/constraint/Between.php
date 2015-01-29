<?php
/**
 * File /framework/validation/constraint/Between.php contains Between constraint class
 * for defining whether given value is within the specified range or not.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Between class is used to define whether given value is within the specified range or not.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Between extends Constraint
{
    /**
     * @var float|int $_min Start point or range
     */
    private $_min;

    /**
     * @var float|int $_max End point of range
     */
    private $_max;

    /**
     * Between constructor takes points for defining range and error message.
     *
     * @param float|int   $min     Start point of range.
     * @param float|int   $max     End point of range.
     * @param null|string $message Error message.
     *
     * @return object Between.
     */
    public function __construct($min, $max, $message = null)
    {
        $this->_min = $min;
        $this->_max = $max;
        $message    = isset($message)?$message:"must belong to ($min;$max)";
        parent::__construct($message);
    }

    /**
     * Method to get start point of range (Between::min).
     *
     * @return float Between::min.
     */
    public function getMin()
    {
        return $this->_min;
    }

    /**
     * Method to set start point of range (Between::min).
     *
     * @param  float|int $min Value for Between::min.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setMin($min)
    {
        if (is_float($min) || is_int($min)) {
            $this->_min = $min;
        } else {
            $parameterType = gettype($min);
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> parameter for Between::setMin method must be 'int' || 'float', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to get end point of range (Between::max).
     *
     * @return float|int Between::max.
     */
    public function getMax()
    {
        return $this->_max;
    }

    /**
     * Method to set end point of range (Between::max).
     *
     * @param  float|int $max Value for Between::max.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setMax($max)
    {
        if (is_float($max) || is_int($max)) {
            $this->_max = $max;
        } else {
            $parameterType = gettype($max);
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> parameter for Between::setMax method must be 'int' || 'float', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to validate whether given value is withing the specified range or not.
     *
     * @param  mixed $value
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is given value inside of range or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            if (is_int($value) || is_float($value)) {
                if ($value > $this->_min && $value < $this->_max) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $parameterType = gettype($value);
                throw new ConstraintException(
                    500,
                    "<strong>Internal server error:</strong> values for specifying range in Between::validate method must be whether 'int' or 'float', '$parameterType' is given"
                );
            }
        } else {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> value for Between::validate method is NULL"
            );
        }
    }
}