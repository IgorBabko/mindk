<?php
/**
 * File /framework/validation/constraint/MinLength.php contains MinLength constraint class
 * to check whether length of current string is not less than min length.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * MinLength class is used to check whether length of current string is not less than min length.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MinLength extends Constraint
{

    /**
     * @var string $min Min allowed length
     */
    private $min;

    /**
     * MinLength constructor takes min length and error message.
     *
     * @param string      $min     Min allowed length.
     * @param null|string $message Error message.
     *
     * @return MinLength MinLength object.
     */
    public function __construct($min, $message = null)
    {
        $this->min = $min;
        $message   = isset($message)?$message:"length must be at least $min character(s)";
        parent::__construct($message);
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
            if (strlen($value) >= $this->min) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for MinLength::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}