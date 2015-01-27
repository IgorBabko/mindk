<?php
/**
 * File /framework/sanitization/Sanitizer.php contains Sanitizer class for sanitization.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization;

use Framework\Exception\SanitizerException;
use Framework\Sanitization\Filter\Filter;

/**
 * Class Sanitizer is used to sanitize data.
 * Default implementation of {@link SanitizerInterface}.
 *
 * @package Framework\Sanitization
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Sanitizer implements SanitizerInterface
{
    /**
     * {@inheritdoc}
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
                        throw new SanitizerException(
                            500, "<strong>Internal server error:</strong> '$className' is not an instance of Filter class"
                        );
                    }
                }
            }
            return $object;
        } else {
            $parameterType = gettype($object);
            throw new SanitizerException(
                500, "<strong>Internal server error:</strong> parameter for Sanitizer::sanitize method must be object, '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitizeValue($value, $filters)
    {
        if (!isset($value)) {
            throw new SanitizerException(
                500,
                "<strong>Internal server error:</strong> first parameter for Sanitizer::sanitizeValue method is NULL"
            );
        } elseif (!is_array($filters) && !is_object($filters)) {
            $parameterType = gettype($filters);
            throw new SanitizerException(
                500, "<strong>Internal server error:</strong> second parameter for Sanitizer::sanitizeValue method is '$parameterType',
                        must be Filter object or array of Filter objects"
            );
        } else {
            $filters = is_object($filters)?array($filters):$filters;
            foreach ($filters as $filter) {
                if ($filter instanceof Filter) {
                    $value = $filter->sanitize($value);
                } else {
                    $className = get_class($filter);
                    throw new SanitizerException(
                        500, "<strong>Internal server error:</strong> '$className' is not an instance of Filter class"
                    );
                }
            }
            return $value;
        }
    }
}