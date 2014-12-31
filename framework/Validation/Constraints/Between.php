<?php
/**
 * File /framework/Validation/Constraints/Between.php contains Between constraint class
 * for defining whether given value is within the specified range or not.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Between class is used to define whether given value is within the specified range or not.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Between extends Constraint
{

    /**
     * @var int $min Start point or range
     */
    private $min;
    /**
     * @var int $max End point of range
     */
    private $max;

    /**
     * Between constructor takes points for defining range and error message.
     *
     * @param int         $min     Start point of range.
     * @param int         $max     End point of range.
     * @param null|string $message Error message.
     *
     * @return Between Between object.
     */
    public function __construct($min, $max, $message = null)
    {
        $this->min = $min;
        $this->max = $max;
        $message   = isset($message)?$message:"must belong to ($min;$max)";
        parent::__construct($message);
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
                if ($value > $this->min && $value < $$this->max) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $parameterType = gettype($value);
                throw new ConstraintException(
                    "002",
                    "Values for specifying range in Between::validate method must be whether 'int' or 'float', '$parameterType' is given");
            }
        } else {
            throw new ConstraintException("003", "Value for Between::validate method is NULL");
        }
    }
}