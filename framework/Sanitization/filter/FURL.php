<?php
/**
 * File /framework/sanitization/filter/FURL.php contains FURL filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FURL filter class is used to sanitize URL.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FURL extends Filter
{
    /**
     * Method to sanitize URL.
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
            return filter_var($value, FILTER_SANITIZE_URL);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Value for FURL::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}