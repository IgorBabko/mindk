<?php
/**
 * File /framework/sanitization/filter/FilterInterface.php contains FilterInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

/**
 * Interface FilterInterface is used to be implemented by Filter class.
 *
 * @api
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface FilterInterface
{
    /**
     * Method to sanitize value. Will be overridden by derived filter classes.
     *
     * @param  mixed $value Value to sanitize.
     *
     * @return mixed Filtered value.
     */
    public function sanitize($value);
}