<?php
/**
 * File /framework/sanitization/filter/FTime.php contains FTime filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FTime filter class is used to sanitize time.
 * User can specify manually which characters can be present in time string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FTime extends Filter
{
    /**
     * @var array $_allowedSymbols Array of characters that can be present in time string.
     */
    private $_allowedSymbols = array();

    /**
     * FTime constructor takes array of characters that can be present in time string.
     *
     * @param  array $allowedSymbols Allowed characters.
     *
     * @return FTime FTime object.
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
                500, "<strong>Internal server error:</strong> parameter for FTime::setAllowedSymbols method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to sanitize time.
     *
     * @param  string $value Source string.
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
            return preg_replace("/[^{$allow}\d]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FTime::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}