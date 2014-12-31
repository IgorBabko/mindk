<?php
/**
 * File framework/Sanitization/Filters/FInt.php contains FInt filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FInt filter class is used to sanitize integer value given as a string.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FInt extends Filter
{
    /**
     * Method to sanitize integer value.
     *
     * @param  string|int $value Value to sanitize.
     *
     * @return string|int Filtered value.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value) || is_int($value)) {
            return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FInt::sanitize method must be 'string' || 'int',
                        '$parameterType' is given"
            );
        }
    }
}