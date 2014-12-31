<?php
/**
 * File /framework/Validation/Constraints/AlphaNumeric.php contains AlphaNumeric constraint class
 * for alpha-numeric values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * AlphaNumeric class is used to validate alpha-numeric values.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class AlphaNumeric extends Constraint
{

    /**
     * @var array $allowedSymbols Array of allowed characters
     */
    public $allowedSymbols;

    /**
     * AlphaNumeric constructor takes array of allowed characters except of alpha-numeric.
     *
     * @param array  $allowedSymbols Array of allowed characters.
     * @param string $message Error message.
     *
     * @return AlphaNumeric AlphaNumeric object.
     */
    public function __construct($allowedSymbols = array(), $message = null)
    {
        $this->allowedSymbols = $allowedSymbols;
        $message = isset($message) ? $message : "must be alpha-numeric";
        parent::__construct($message);
    }

    /**
     * Method to validate alpha-numeric value.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value valid or not?
     */
    public function validate($value)
    {
        $allow = "";
        if (!empty($this->allowed)) {
            foreach ($this->allowed as $item) {
                $allow .= "\\$item";
            }
        }

        if (is_int($value) || is_float($value)) {
            return true;
        } elseif (is_string($value)) {
            if (preg_match("/^[{$allow}a-zA-Z0-9]*$/", $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException(
                "001", "Value for AlphaNumeric::validate method must be 'string' || 'int' || 'float', '$parameterType' is given"
            );
        }
    }
}