<?php
/**
 * File /framework/validation/constraint/Match.php contains Match constraint class
 * to check whether current value matches specified value.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * Match class is used to check whether two values are equal or not.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Match extends Constraint
{
    /**
     * @var string $_equalValue Value to compare with
     */
    private $_equalValue;

    /**
     * Match constructor takes value to compare with and error message.
     *
     * @param  string $equalValue Value to compare with.
     * @param  null   $message    Error message.
     *
     * @return object Match.
     */
    public function __construct($equalValue, $message = null)
    {
        $this->_equalValue = $equalValue;
        $message           = isset($message)?$message:"must match value '$equalValue'";
        parent::__construct($message);
    }

    /**
     * Method to get value to compare with.
     *
     * @return null|string Value to compare with.
     */
    public function getEqualValue()
    {
        return $this->_equalValue;
    }

    /**
     * Method to set value to compare with.
     *
     * @param  string $equalValue Value to compare with.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setEqualValue($equalValue)
    {
        if (is_string($equalValue)) {
            $this->_equalValue = $equalValue;
        } else {
            $parameterType = gettype($equalValue);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> parameter for Match::setEqualValue method must be 'string', '$parameterType' is given"
            );
        }
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
            if ($value == $this->_equalValue) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> parameter for Match::validate method is NULL"
            );
        }
    }
}