<?php
/**
 * File framework/Sanitization/Filters/FPhone.php contains FPhone filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FPhone filter class is used to sanitize phone.
 * User can specify manually which characters phone string can contain.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FPhone extends Filter
{

    /**
     * @var array $allowedSymbols Array of characters which phone string can contain.
     */
    private $allowedSymbols = array();

    /**
     * FPhone constructor takes array of characters which phone string can contain.
     *
     * @param  array $allowedSymbols Allowed characters.
     *
     * @return FPhone FPhone instance.
     */
    public function __construct($allowedSymbols = array())
    {
        $this->allowedSymbols = $allowedSymbols;
    }

    /**
     * Method to sanitize phone.
     *
     * @param  string $value Value to sanitize.
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
                "001", "Parameter for FPhone::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}