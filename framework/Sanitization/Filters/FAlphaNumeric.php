<?php
/**
 * File framework/Sanitization/Filters/FAlphaNumeric.php contains FAlphaNumeric filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FAlphaNumeric filter class is used to leave only alphabetic and numeric characters in source string.
 * Optionally user can specify characters which he wants to be present except of alpha-numeric.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FAlphaNumeric extends Filter
{

    /**
     * @var array $allowedSymbols Allowed characters.
     */
    private $allowedSymbols;

    /**
     * Constructor which takes array of allowed characters.
     *
     * @param  array $allowedSymbols Allowed characters.
     *
     * @return FAlphaNumeric object.
     */
    public function __construct($allowedSymbols = array())
    {
        $this->allowedSymbols = $allowedSymbols;
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