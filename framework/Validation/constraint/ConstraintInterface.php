<?php
/**
 * File /framework/validation/constraint/ConstraintInterface.php contains ConstraintInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

/**
 * Interface ConstraintInterface is used to be implemented by Constraint class.
 *
 * @api
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ConstraintInterface
{
    /**
     * Method to validate $value according to constraint object. Will be overridden
     * in derived classes.
     *
     * @param  mixed $value Value to validate.
     *
     * @return mixed Is value valid or not?
     */
    public function validate($value);

    /**
     * Method to get error message of particular constraint.
     *
     * @return string Error message.
     */
    public function getMessage();
}