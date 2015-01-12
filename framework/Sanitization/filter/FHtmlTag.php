<?php
/**
 * File /framework/sanitization/filter/FHtmlTag.php contains FHtmlTag filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FHtmlTag filter class is used to strip html tags.
 * User can define which tags must not be deleted.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FHtmlTag extends Filter
{
    /**
     * @var array $_allowedHtmlTags Tags that must not be deleted
     */
    private $_allowedHtmlTags;

    /**
     * FHtmlTag constructor takes string or array of tags that must not be deleted.
     *
     * @param  array $allowedHtmlTags Allowed html tags.
     *
     * @return FHtmlTag FHtmlTag object.
     */
    public function __construct($allowedHtmlTags = array())
    {
        if (is_array($allowedHtmlTags)) {
            $this->_allowedHtmlTags = join($allowedHtmlTags, '');
        } else {
            $this->_allowedHtmlTags = $allowedHtmlTags;
        }
    }

    /**
     * Method to get allowed html tags.
     *
     * @return array Allowed html tags.
     */
    public function getAllowedHtmlTags()
    {
        return $this->_allowedHtmlTags;
    }

    /**
     * Method to set allowed html tags.
     *
     * @param  array|string $allowedHtmlTags Allowed html tags.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function setAllowedHtmlTags($allowedHtmlTags = array())
    {
        if (is_array($allowedHtmlTags) || is_string($allowedHtmlTags)) {
            if (is_array($allowedHtmlTags)) {
                $this->_allowedHtmlTags = join($allowedHtmlTags, '');
            } else {
                $this->_allowedHtmlTags = $allowedHtmlTags;
            }
        } else {
            $parameterType = gettype($allowedHtmlTags);
            throw new FilterException(
                "001", "Parameter for FHtmlTag::setAllowedHtmlTags method must be 'array' || 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to delete html tags from string except of allowed tags.
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
            return strip_tags($value, $this->_allowedHtmlTags);
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "003", "Parameter for FHtmlTag::sanitize method must be 'string', $parameterType is given"
            );
        }
    }
}