<?php
/**
 * File /framework/validation/constraint/NotBlank.php contains NotBlank constraint class
 * to make sure that value is not blank.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * NotBlank class is used to make sure that value is not blank.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class NotBlank extends Constraint
{
    /**
     * NotBlank constructor takes error message.
     *
     * @param  null|string $message Error message.
     *
     * @return NotBlank NotBlank object.
     */
    public function __construct($message = null)
    {
        $message = isset($message)?$message:"must not be blank";
        parent::__construct($message);
    }

    /**
     * Method to make sure that value is not blank.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is value not blank?
     */
    public function validate($value)
    {
        if (!isset($value)) {
            throw new ConstraintException("001", "Value for NotBlank::validate method is NULL");
        } elseif (empty($value) && $value != '0') {
            return false;
        } elseif (preg_match("/^\s*$/", $value)) {
            return false;
        } else {
            info($value);
            return true;
        }
    }
}