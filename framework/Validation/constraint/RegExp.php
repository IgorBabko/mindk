<?php
/**
 * File /framework/validation/constraint/RegExp.php contains RegExp constraint class
 * to validate value according to specified regular expression.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * RegExp class is used to validate value according to regular expression.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RegExp extends Constraint
{
    /**
     * @var string $_pattern Regular expression for validation
     */
    private $_pattern;

    /**
     * RegExp constructor takes regular expression for validation and error message.
     *
     * @param  string        $pattern Regular expression for validation.
     * @param  null|string   $message Error message.
     *
     * @return RegExp RegExp object.
     */
    public function __construct($pattern, $message = null)
    {
        $this->_pattern = $pattern;
        $message        = isset($message)?$message:"must match pattern: $pattern";
        parent::__construct($message);
    }

    /**
     * Method to get pattern.
     *
     * @return null|string Pattern.
     */
    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * Method to set pattern.
     *
     * @param  string $pattern Pattern to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setPattern($pattern)
    {
        if (is_string($pattern)) {
            $this->_pattern = $pattern;
        } else {
            $parameterType = gettype($pattern);
            throw new ConstraintException(
                "001", "Value for RegExp::setPattern method must be 'string', '$parameterType' is given"
            );
        }
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
            if (filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $this->_pattern)))) {
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