<?php
/**
 * File framework/validation/Validator.php contains Validator class for validation.
 *
 * PHP version 5
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation;

use Framework\Exception\ValidatorException;
use Framework\Validation\Constraint\Constraint;

/**
 * Class Validator is used to validate data come from insecure sources such as user input.
 * Default implementation of {@link ValidatorInterface}.
 *
 * @package Framework\Validation
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array $_errorList Validation errors
     */
    private static $_errorList = array();

    /**
     * {@inheritdoc}
     */
    public static function validate($object)
    {
        if (is_object($object)) {
            self::resetErrorList();
            $fieldConstraints = $object->getConstraints();
            $data             = $object->getData();
            $object           = isset($data)?$data:$object;
            foreach ($fieldConstraints as $field => $constraints) {
                foreach ($constraints as $constraint) {
                    if ($constraint instanceof Constraint) {
                        if (!$constraint->validate($object->$field)) {
                            self::$_errorList[$field] = $constraint->getMessage();
                        }
                    } else {
                        $className = get_class($constraint);
                        throw new ValidatorException(
                            500, "<strong>Internal server error:</strong> '$className' object is not an instance of Constraint class"
                        );
                    }
                }
            }
            return (count(self::$_errorList) > 0)?self::$_errorList:true;
        } else {
            $parameterType = gettype($object);
            throw new ValidatorException(
                500, "<strong>Internal server error:</strong> parameter for Validator::validate method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function validateValue($value, $constraints)
    {
        if (!isset($value)) {
            throw new ValidatorException(
                500,
                "<strong>Internal server error:</strong> first parameter for Validator::validateValue method is NULL"
            );
        } elseif (!is_array($constraints) && !is_object($constraints)) {
            $parameterType = gettype($constraints);
            throw new ValidatorException(
                500, "<strong>Internal server error:</strong> second parameter for Validator::validateValue method is $parameterType,
                        must be Constraint object or array of Constraint objects"
            );
        } else {
            self::resetErrorList();
            $constraints = is_object($constraints)?array($constraints):$constraints;
            foreach ($constraints as $constraint) {
                if ($constraint instanceof Constraint) {
                    if (!$constraint->validate($value)) {
                        self::$_errorList[$value] = $constraint->getMessage();
                    }
                } else {
                    $className = get_class($constraint);
                    throw new ValidatorException(
                        500, "<strong>Internal server error:</strong> '$className' value is not an instance of Constraint class"
                    );
                }
            }
            return (count(self::$_errorList) > 0)?self::$_errorList:true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getErrorList()
    {
        return self::$_errorList;
    }

    /**
     * {@inheritdoc}
     */
    public static function resetErrorList()
    {
        self::$_errorList = array();
    }
}