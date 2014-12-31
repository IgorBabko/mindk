<?php
/**
 * File framework/Sanitization/Filters/FHtmlTag.php contains FHtmlTag filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FHtmlTag filter class is used to strip html tags.
 * User can define which tags must not be deleted.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlTag extends Filter
{

    /**
     * @var array $allowedHtmlTags Tags that must not be deleted
     */
    private $allowedHtmlTags;

    /**
     * FHtmlTag constructor takes string or array of tags that must not be deleted.
     *
     * @param array $allowedHtmlTags Allowed html tags.
     *
     * @return FHtmlTag FHtmlTag object.
     */
    public function __construct($allowedHtmlTags = array())
    {
        if (is_array($allowedHtmlTags)) {
            $this->allowedHtmlTags = join($allowedHtmlTags, '');
        }
        $this->allowedHtmlTags = $allowedHtmlTags;
    }

    /**
     * Method to delete html tags from string except of allowed tags.
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
            return strip_tags($value, $this->allowedHtmlTags);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "003", "Parameter for FHtmlTag::sanitize method must be 'string', $parameterType is given"
            );
        }
    }
}