<?php
/**
 * File /framework/validation/constraint/AlphaNumeric.php contains AlphaNumeric constraint class
 * for alpha-numeric values.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * AlphaNumeric class is used to validate alpha-numeric values.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class AlphaNumeric extends Constraint
{
    /**
     * @var array $_allowedSymbols Array of allowed characters
     */
    private $_allowedSymbols;

    /**
     * AlphaNumeric constructor takes array of allowed characters except of alpha-numeric.
     *
     * @param  string $message Error message.
     * @param  array $allowedSymbols Array of allowed characters.
     *
     * @return object AlphaNumeric.
     */
    public function __construct($message = null, $allowedSymbols = array())
    {
        $this->_allowedSymbols = $allowedSymbols;
        $message = isset($message) ? $message : "must be alpha-numeric";
        parent::__construct($message);
    }

    /**
     * Method to get allowed symbols.
     *
     * @return array Allowed symbols.
     */
    public function getAllowedSymbols()
    {
        return $this->_allowedSymbols;
    }

    /**
     * Method to set allowed symbols.
     *
     * @param  array $allowedSymbols Allowed symbols.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setAllowedSymbols($allowedSymbols)
    {
        if (is_array($allowedSymbols)) {
            $this->_allowedSymbols = $allowedSymbols;
        } else {
            $parameterType = gettype($allowedSymbols);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> parameter for AlphaNumeric::setAllowedSymbols method must be 'array', '$parameterType' is given"
            );
        }
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
        if (!empty($this->_allowedSymbols)) {
            foreach ($this->_allowedSymbols as $item) {
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
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for AlphaNumeric::validate method must be 'string' || 'int' || 'float', '$parameterType' is given"
            );
        }
    }
}