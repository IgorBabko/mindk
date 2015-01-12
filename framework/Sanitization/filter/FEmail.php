<?php
/**
 * File framework/sanitization/filter/FEmail.php contains FEmail filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FEmail filter class is used to filter email address.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FEmail extends Filter
{
    /**
     * Method to sanitize email.
     *
     * @param  string $value Value to sanitize.
     *
     * @return string Filtered value.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return filter_var($value, FILTER_SANITIZE_EMAIL);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FEmail::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}