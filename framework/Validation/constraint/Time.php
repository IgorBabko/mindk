<?php
/**
 * File /framework/validation/constraint/Time.php contains Time constraint class
 * to validate value that must represent time in given format. User can specify time format.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Time class is used to validate time in given format.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Time extends Constraint
{

    /**
     * @var null|string $pattern Pattern for time validation
     */
    private $pattern;

    /**
     * Time constructor takes patter for time validation and error message.
     *
     * @param null|string $pattern Pattern for time validation.
     * @param null|string $message Error message.
     *
     * @return Time Time object.
     */
    public function __construct($pattern = null, $message = null)
    {
        $this->pattern = empty($pattern)?"/^([01]\\d|2[0123]):(60|[012345]\\d)$/":$pattern;
        $message       = isset($message)?$message:" must be time matching pattern: {$this->pattern}";
        parent::__construct($message);
    }

    /**
     * Method to validate time in given format.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is date or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if (preg_match($this->pattern, $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for Time::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}