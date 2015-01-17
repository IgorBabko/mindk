<?php
/**
 * File framework/sanitization/filter/FDate.php contains FDate filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FDate filter class is used to sanitize date.
 * User can define manually which characters he wants to be present in date.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FDate extends Filter
{
    /**
     * @var array $allowedSymbols Allowed characters in date.
     */
    private $_allowedSymbols = array();

    /**
     * FDate constructor takes array of allowed characters.
     *
     * @param  array $allowedSymbols Array of allowed characters.
     * @return FDate FDate object.
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
                "001", "Parameter for FDate::setAllowedSymbols method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to sanitize date.
     *
     * @param  string $value Date to sanitize.
     *
     * @return string Filtered value.
     *
     * @throws FilterException FilterException instance.
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
            return preg_replace("/[^{$allow}\d]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FDate::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}