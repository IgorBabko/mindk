<?php
/**
 * File /framework/sanitization/filter/FNumeric.php contains FNumeric filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FNumeric filter class is used to delete all non-numeric characters from source string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FNumeric extends Filter
{
    /**
     * Method to delete all non-numeric characters.
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
            return preg_replace("/[^\d\.]|\.{2,}/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FNumeric::sanitize method must be 'string',
                    '$parameterType' is given"
            );
        }
    }
}