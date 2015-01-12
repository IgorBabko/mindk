<?php
/**
 * File /framework/sanitization/filter/FPhone.php contains FPhone filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FPhone filter class is used to sanitize phone.
 * User can specify manually which characters phone string can contain.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FPhone extends Filter
{
    /**
     * @var array $_allowedSymbols Array of characters which phone string can contain.
     */
    private $_allowedSymbols = array();

    /**
     * FPhone constructor takes array of characters which phone string can contain.
     *
     * @param  array $allowedSymbols Allowed characters.
     *
     * @return FPhone FPhone instance.
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
                "001", "Parameter for FPhone::setAllowedSymbols method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to sanitize phone.
     *
     * @param  string $value Value to sanitize.
     *
     * @throws FilterException FilterException instance.
     *
     * @return string Filtered value.
     */
    public function sanitize($value)
    {
        $allow = "";
        if (!empty($this->_allowedSymbols)) {
            foreach ($this->_allowedSymbols as $item) {
                $allow .= "\\$item";
            }
        }

        if (is_string($value)) {
            return preg_replace("/[^{$allow}\\d]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FPhone::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}