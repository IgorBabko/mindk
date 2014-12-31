<?php
/**
 * File framework/Sanitization/Filters/FTime.php contains FTime filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FTime filter class is used to sanitize time.
 * User can specify manually which characters can be present in time string.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FTime extends Filter
{

    /**
     * @var array $allowedSymbols Array of characters that can be present in time string.
     */
    private $allowedSymbols = array();

    /**
     * FTime constructor takes array of characters that can be present in time string.
     *
     * @param array $allowedSymbols Allowed characters.
     *
     * @return FTime FTime object.
     */
    public function __construct($allowedSymbols = array())
    {
        $this->allowedSymbols = $allowedSymbols;
    }

    /**
     * Method to sanitize time.
     *
     * @param  string $value Source string.
     *
     * @return string Filtered value.
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

        if (is_string($value)) {
            return preg_replace("/[^{$allow}\\d]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FTime::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}