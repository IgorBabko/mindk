<?php
/**
 * File framework/Sanitization/Filters/FAlpha.php contains FAlpha filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FAlpha filter class is used to delete all non-alphabetic characters from source string.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FAlpha extends Filter
{

    /**
     * Method to make alpha sanitization.
     *
     * @param  string $value Source string.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return preg_replace("/[^a-zA-Z]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FAlpha::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}