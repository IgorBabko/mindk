<?php
/**
 * File framework/Validation/Validator.php contains class for validation.
 *
 * PHP version 5
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation;

use Framework\Exception\ValidatorException;
use Framework\Validation\Constraints\Constraint;

/**
 * Class Validator is used to validate data come from insecure sources such as user input.
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Validator
{

    /**
     * @var array $errorList Validation errors.
     */
    public static $errorList = array();

    /**
     * Method to validate objects such as models and forms.
     *
     * @param mixed $object Object to validate.
     *
     * @throws ValidatorException ValidatorException instance.
     *
     * @return array|bool True if data is valid otherwise array of validation errors.
     */
    public static function validate($object)
    {
        if (is_object($object)) {
            self::resetErrorList();
            $fieldRules = $object->getRules();
            $object     = isset($object->data)?$object->data:$object;
            foreach ($fieldRules as $field => $rules) {
                foreach ($rules as $rule) {
                    if ($rule instanceof Constraint) {
                        if (!$rule->validate($object->$field)) {
                            self::$errorList[$field] = $rule->getMessage();
                        }
                    } else {
                        $className = get_class($rule);
                        throw new ValidatorException(
                            "001", "'$className' object is not an instance of Constraint class"
                        );
                    }
                }
            }
            return (count(self::$errorList) > 0)?self::$errorList:true;
        } else {
            $parameterType = gettype($object);
            throw new ValidatorException(
                "002", "Parameter for Validator::validate method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to validate primitive values (e.g. int, string, ...).
     *
     * @param mixed        $value       Value to validate.
     * @param array|object $constraints Constraints for validation (Constraint object or array of Constraint objects).
     *
     * @throws ValidatorException ValidatorException instance.
     *
     * @return array|bool         True if data is valid otherwise array of validation errors.
     */
    public static function validateValue($value, $constraints)
    {
        if (!isset($value)) {
            throw new ValidatorException("003", "First parameter for Validator::validateValue method is NULL");
        } elseif (!is_array($constraints) && !is_object($constraints)) {
            $parameterType = gettype($constraints);
            throw new ValidatorException(
                "004", "Second parameter for Validator::validateValue method is $parameterType,
                        must be Constraint object or array of Constraint objects"
            );
        } else {
            self::resetErrorList();
            $constraints = is_object($constraints)?array($constraints):$constraints;
            foreach ($constraints as $constraint) {
                if ($constraint instanceof Constraint) {
                    if (!$constraint->validate($value)) {
                        self::$errorList[$value] = $constraint->getMessage();
                    }
                } else {
                    $className = get_class($constraint);
                    throw new ValidatorException("001", "'$className' value is not an instance of Constraint class");
                }
            }
            return (count(self::$errorList) > 0)?self::$errorList:true;
        }
    }

    /**
     * Method to get validation errors.
     *
     * @return void
     */
    public static function resetErrorList()
    {
        self::$errorList = array();
    }
}