<?php
/**
 * File framework/sanitization/filter/FHtmlSpecialChar.php contains FHtmlSpecialChar filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FHtmlSpecialChar filter class is used to convert
 * predefined characters "<" (less than) and ">" (greater than) to HTML entities.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlSpecialChar extends Filter
{
    /**
     * Method to convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities.
     *
     * @param string $value Source string.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return htmlspecialchars($value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FHtmlSpecialChar::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}