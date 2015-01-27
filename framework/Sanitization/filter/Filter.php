<?php
/**
 * File framework/sanitization/filter/Filter.php contains
 * Filter class that is superclass for all filters.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

/**
 * Filter class is a superclass class for all filters.
 * Default implementation of {@link FilterInterface}.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
abstract class Filter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function sanitize($value);
}