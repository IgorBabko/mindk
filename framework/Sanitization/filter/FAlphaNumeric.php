<?php
/**
 * File framework/sanitization/filter/FAlphaNumeric.php contains FAlphaNumeric filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FAlphaNumeric filter class is used to leave only alphabetic and numeric characters in source string.
 * Optionally user can specify characters which he wants to be present except of alpha-numeric.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FAlphaNumeric extends Filter
{
    /**
     * @var array $_allowedSymbols Allowed characters.
     */
    private $_allowedSymbols;

    /**
     * Constructor which takes array of allowed characters.
     *
     * @param  array $allowedSymbols Allowed characters.
     *
     * @return FAlphaNumeric object.
     */
    public function __construct($allowedSymbols = array())
    {
        $this->_allowedSymbols = $allowedSymbols;
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
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function setAllowedSymbols($allowedSymbols)
    {
        if (is_array($allowedSymbols)) {
            $this->_allowedSymbols = $allowedSymbols;
        } else {
            $parameterType = gettype($allowedSymbols);
            throw new FilterException(
                "001", "Parameter for FAlphaNumeric::setAllowedSymbols method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to make alpha-numeric sanitization.
     *
     * @param mixed $value Value to sanitize.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        $allow = "";
        if (!empty($this->allowedSymbols)) {
            foreach ($this->allowedSymbols as $item) {
                $allow .= "\\$item";
            }
        }

        if (is_int($value) || is_float($value)) {
            return $value;
        } elseif (is_string($value)) {
            return preg_replace("/[^{$allow}a-zA-Z0-9]/", '', $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FAlphaNumeric::sanitize method must be 'string' || 'int' || 'float',
                        '$parameterType' is given"
            );
        }
    }
}