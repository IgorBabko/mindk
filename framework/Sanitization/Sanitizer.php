<?php
/**
 * File framework/Sanitization/Sanitizer.php contains class for sanitization.
 *
 * PHP version 5
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization;

use Framework\Exception\SanitizerException;
use Framework\Sanitization\Filters\Filter;

/**
 * Class Sanitizer is used to sanitize data.
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Sanitizer
{
    /**
     * Method to filter objects.
     *
     * @param mixed $object Object that must be filtered.
     *
     * @return mixed Filtered object.
     *
     * @throws SanitizerException SanitizerException instance.
     */
    public static function sanitize($object)
    {
        if (is_object($object)) {
            $fieldFilters = $object->getFilters();
            $object       = isset($object->data)?$object->data:$object;
            foreach ($fieldFilters as $field => $filters) {
                foreach ($filters as $filter) {
                    if ($filter instanceof Filter) {
                        $object->$field = $filter->sanitize($object->$field);
                    } else {
                        $className = get_class($filter);
                        throw new SanitizerException("001", "'$className' is not an instance of Filter class");
                    }
                }
            }
            return $object;
        } else {
            $parameterType = gettype($object);
            throw new SanitizerException(
                "002", "Parameter for Sanitizer::sanitize method must be object, '$parameterType' is given"
            );
        }
    }

    /**
     * Method to filter values of primitive data types.
     *
     * @param mixed        $value   Values that must be filtered.
     * @param array|Filter $filters Filter object or array of filter objects.
     *
     * @return mixed Filtered value.
     *
     * @throws SanitizerException SanitizerException instance.
     */
    public static function sanitizeValue($value, $filters)
    {
        if (!isset($value)) {
            throw new SanitizerException("003", "First parameter for Sanitizer::sanitizeValue method is NULL");
        } elseif (!is_array($filters) && !is_object($filters)) {
            $parameterType = gettype($filters);
            throw new SanitizerException(
                "004", "Second parameter for Sanitizer::sanitizeValue method is '$parameterType',
                        must be Filter object or array of Filter objects"
            );
        } else {
            $filters = is_object($filters)?array($filters):$filters;
            foreach ($filters as $filter) {
                if ($filter instanceof Filter) {
                    $value = $filter->sanitize($value);
                } else {
                    $className = get_class($filter);
                    throw new SanitizerException("001", "'$className' is not an instance of Filter class");
                }
            }
            return $value;
        }
    }
}