<?php
/**
 * File /framework/sanitization/filter/FHtmlEntity.php contains FHtmlEntity filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FHtmlEntity filter class is used to convert some characters to HTML entities.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlEntity extends Filter
{
    /**
     * Method to convert some characters to HTML entities.
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
            return htmlentities($value, ENT_QUOTES, "UTF-8");
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FHtmlEntity::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}