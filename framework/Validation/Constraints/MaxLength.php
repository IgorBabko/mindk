<?php
/**
 * File /framework/Validation/Constraints/MaxLength.php contains MaxLength constraint class
 * to check whether length of current string is no more than max length.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * MaxLength class is used to check whether length of current string is no more than max length.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MaxLength extends Constraint
{

    /**
     * @var string $max Max allowed length
     */
    private $max;

    /**
     * MaxLength constructor takes max length and error message.
     *
     * @param string        $max     Max allowed length.
     * @param null|string   $message Error message.
     *
     * @return MaxLength MaxLength object.
     */
    public function __construct($max, $message = null)
    {
        $this->max = $max;
        $message   = isset($message)?$message:"length must be no more than $max character(s)";
        parent::__construct($message);
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
            if (strlen($value) <= $this->max) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for MaxLength::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}