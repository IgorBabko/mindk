<?php
/**
 * File /framework/validation/constraint/RegExp.php contains RegExp constraint class
 * to validate value according to specified regular expression.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * RegExp class is used to validate value according to regular expression.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RegExp extends Constraint
{

    /**
     * @var string $pattern Regular expression for validation
     */
    private $pattern;

    /**
     * RegExp constructor takes regular expression for validation and error message.
     *
     * @param string        $pattern Regular expression for validation.
     * @param null|string   $message Error message.
     *
     * @return RegExp RegExp object.
     */
    public function __construct($pattern, $message = null)
    {
        $this->pattern = $pattern;
        $message       = isset($message)?$message:"must match pattern: $pattern";
        parent::__construct($message);
    }

    /**
     * Method to validate value according to regular expression.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value satisfy given regular expression or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $this->pattern)))) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for RegExp::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}