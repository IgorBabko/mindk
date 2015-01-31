<?php
/**
 * File /framework/validation/ValidatorInterface.php contains ValidatorInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation;

/**
 * Interface ValidatorInterface is used to be implemented by Validator class.
 *
 * @api
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ValidatorInterface
{
    /**
     * Method to validate objects such as models and forms.
     *
     * @param  mixed $object Object to validate.
     *
     * @throws \Framework\Exception\ValidatorException ValidatorException instance.
     *
     * @return array|bool True if data is valid otherwise array of validation errors.
     */
    public static function validate($object);

    /**
     * Method to validate primitive values (e.g. int, string, ...).
     *
     * @param  mixed $value Value to validate.
     * @param  array|object $constraints Constraints for validation (Constraint object or array of Constraint objects).
     *
     * @throws \Framework\Exception\ValidatorException ValidatorException instance.
     *
     * @return array|bool True if data is valid otherwise array of validation errors.
     */
    public static function validateValue($value, $constraints);

    /**
     * Method to get all validation errors.
     *
     * @return array Validation errors.
     */
    public static function getErrorList();

    /**
     * Method to get validation errors.
     *
     * @return void
     */
    public static function resetErrorList();
}