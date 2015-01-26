<?php
/**
 * File /framework/sanitization/filter/FWhitespace.php contains FWhitespace filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FWhitespace filter class is used to delete whitespaces.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FWhitespace extends Filter
{
    /**
     * Method to delete whitespaces.
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
            $value = trim($value);
            $value = preg_replace("/[\n\r\t]+/", "", $value);
            return preg_replace("/\s{2,}/", " ", $value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FWhitespace::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}