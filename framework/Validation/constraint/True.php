<?php
/**
 * File /framework/validation/constraint/True.php contains True constraint class
 * to check whether value is true or not.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * True class is used to check whether value is true or not.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class True extends Constraint
{

    /**
     * @var array $booleanList Array of values that represent true
     */
    private $booleanList;

    /**
     * True constructor takes array of values that represent true and error message.
     *
     * @param array       $booleanList Array of values that represent true.
     * @param null|string $message     Error message.
     *
     * @return \Framework\Validation\Constraints\True True object.
     */
    public function __construct($booleanList = array('1', 'true', 'yes', 'on'), $message = null)
    {
        $this->booleanList = $booleanList;
        $message           = isset($message)?$message:"must be true";
        parent::__construct($message);
    }

    /**
     * Method to check whether value is true or not.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is true or not?
     */
    public function validate($value)
    {
        if (is_string($value) || is_int($value) || is_float($value) || is_bool($value)) {
            if (in_array($value, $this->booleanList)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for True::validate method must be 'string' || 'int' || 'float' || 'bool', '$parameterType' is given"
            );
        }
    }
}