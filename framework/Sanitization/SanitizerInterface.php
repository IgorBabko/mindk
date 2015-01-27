<?php
/**
 * File /framework/sanitization/SanitizerInterface.php contains SanitizerInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization;

/**
 * Interface SanitizerInterface is used to be implemented by Sanitizer class.
 *
 * @api
 *
 * @package Framework\Sanitization
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface SanitizerInterface
{
    /**
     * Method to filter objects.
     *
     * @param  mixed $object Object that must be filtered.
     *
     * @throws \Framework\Exception\SanitizerException SanitizerException instance.
     *
     * @return mixed Filtered object.
     */
    public static function sanitize($object);

    /**
     * Method to filter values of primitive data types.
     *
     * @param  mixed                $value   Values that must be filtered.
     * @param  array|Filter\Filter $filters Filter object or array of filter objects.
     *
     * @throws \Framework\Exception\SanitizerException SanitizerException instance.
     *
     * @return mixed Filtered value.
     */
    public static function sanitizeValue($value, $filters);
}