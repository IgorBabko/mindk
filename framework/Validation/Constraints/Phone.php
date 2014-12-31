<?php
/**
 * File /framework/Validation/Constraints/Phone.php contains Phone constraint class
 * to validate phone. User can specify pattern for phone validation.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * Phone class is used to validate phone.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Phone extends Constraint
{

    /**
     * @var null|string $pattern Pattern for phone validation
     */
    private $pattern;

    /**
     * Phone constructor takes pattern for phone validation and error message.
     *
     * @param null|string $pattern Pattern for phone validation.
     * @param null|string $message Error message.
     *
     * @return Phone Phone object.
     */
    public function __construct($pattern = null, $message = null)
    {
        $this->pattern = empty($pattern)?"/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/":$pattern;
        $message       = isset($message)?$message:"must be phone number matching pattern: {$this->pattern}";
        parent::__construct($message);
    }

    /**
     * Method to validate phone.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is phone valid or not?
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
                "001", "Value for Phone::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}