<?php
/**
 * File framework/sanitization/filter/FNumeric.php contains FNumeric filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FNumeric filter class is used to delete all non-numeric characters from source string.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FNumeric extends Filter
{

    /**
     * Method to delete all non-numeric characters.
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
            return preg_replace("/[^\\d\\.]|\\.{2,}/", "", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FNumeric::sanitize method must be 'string',
                    '$parameterType' is given"
            );
        }
    }
}