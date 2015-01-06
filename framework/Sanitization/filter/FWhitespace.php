<?php
/**
 * File framework/sanitization/filter/FWhitespace.php contains FWhitespace filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FWhitespace filter class is used to delete whitespaces.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FWhitespace extends Filter
{

    /**
     * Method to delete whitespaces.
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
            $value = trim($value);
            $value = preg_replace("/[\n\r\t]+/", "", $value);
            return preg_replace("/\\s{2,}/", " ", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FWhitespace::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}