<?php
/**
 * File /framework/sanitization/filter/FHtmlSpecialChar.php contains FHtmlSpecialChar filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FHtmlSpecialChar filter class is used to convert
 * predefined characters "<" (less than) and ">" (greater than) to HTML entities.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlSpecialChar extends Filter
{
    /**
     * Method to convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities.
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
            return htmlspecialchars($value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FHtmlSpecialChar::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}