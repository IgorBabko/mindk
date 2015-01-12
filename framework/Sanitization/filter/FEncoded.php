<?php
/**
 * File framework/sanitization/filter/FEncoded.php contains FEncoded filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FEncoded filter class is used to encode special characters.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FEncoded extends Filter
{
    /**
     * Method to encode special characters.
     *
     * @param  string $value Source string to encode.
     *
     * @return string Filtered value.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return filter_var($value, FILTER_SANITIZE_ENCODED);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FEncoded::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}