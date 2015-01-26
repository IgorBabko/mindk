<?php
/**
 * File /framework/sanitization/filter/FInt.php contains FInt filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FInt filter class is used to sanitize integer value given as a string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FInt extends Filter
{
    /**
     * Method to sanitize integer value.
     *
     * @param  string|int $value Value to sanitize.
     *
     * @throws FilterException FilterException instance.
     *
     * @return string|int Filtered value.
     */
    public function sanitize($value)
    {
        if (is_string($value) || is_int($value)) {
            return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FInt::sanitize method must be 'string' || 'int',
                        '$parameterType' is given"
            );
        }
    }
}