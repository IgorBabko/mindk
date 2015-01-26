<?php
/**
 * File framework/sanitization/filter/FAlpha.php contains FAlpha filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FAlpha filter class is used to delete all non-alphabetic characters from source string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FAlpha extends Filter
{
    /**
     * Method to make alpha sanitization.
     *
     * @param  string $value Source string.
     *
     * @throws FilterException FilterException instance.
     *
     * @return string Filtered string.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return preg_replace("/[^a-zA-Z]/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FAlpha::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}