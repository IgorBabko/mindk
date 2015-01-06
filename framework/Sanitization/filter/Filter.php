<?php
/**
 * File framework/sanitization/filter/Filter.php contains
 * Filter class that is superclass for all filters.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

/**
 * Filter class is a superclass class for all filters.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
abstract class Filter
{

    /**
     * Method to sanitize value. Will be overridden by derived filter classes.
     *
     * @param  mixed $value Value to sanitize.
     *
     * @return mixed Filtered value.
     */
    abstract public function sanitize($value);
}