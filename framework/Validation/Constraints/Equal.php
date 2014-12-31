<?php
/**
 * File /framework/Validation/Constraints/Equal.php contains Equal constraint class
 * to check whether current value is equal to specified value.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Equal class is used to check whether two values are equal or not.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Equal extends Constraint
{

    /**
     * @var string $equalValue Value to compare with
     */
    private $equalValue;

    /**
     * Equal constructor takes value to compare with and error message.
     *
     * @param string $equalValue Value to compare with.
     * @param null   $message    Error message.
     *
     * @return Equal Equal object.
     */
    public function __construct($equalValue, $message = null)
    {
        $this->equalValue = $equalValue;
        $message          = isset($message)?$message:"must be equal to $equalValue";
        parent::__construct($message);
    }

    /**
     * Method to check whether values are equal or not.
     *
     * @param  mixed $value Value to compare to.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Are values equal or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            if ($value == $this->equalValue) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException("001", "Value for Equal::validate method is NULL");
        }
    }
}