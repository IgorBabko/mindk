<?php
/**
 * File framework/sanitization/filter/FHtmlEndOfLine.php contains FHtmlEndOfLine filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FHtmlEndOfLine filter class is used to replace all end-line characters on '<br />' tag.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlEndOfLine extends Filter
{

    /**
     * Method to replace all end-line characters on '<br />' tag.
     *
     * @param  string $value Source string.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException object.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            return nl2br($value);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FHtmlEndOfLine::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}