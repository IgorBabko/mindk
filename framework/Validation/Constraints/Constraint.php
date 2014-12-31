<?php
/**
 * File /Framework/Validation/Constraints/Constraint.php contains superclass
 * for all validation constraints.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

/**
 * Class Constraint is a superclass for all validation constraints.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
abstract class Constraint
{
    /**
     * @var string $message Error message for particular constraint
     */
    protected $message;

    /**
     * Constructor which sets error message for particular constraint.
     *
     * @param  string $message Error message.
     *
     * @return Constraint Constraint object.
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Method to validate $value according to constraint object. Will be overridden
     * in derived classes.
     *
     * @param  mixed $value Value to validate.
     *
     * @return mixed Is value valid or not?
     */
    abstract public function validate($value);

    /**
     * Method to get error message of particular constraint.
     *
     * @return string Error message.
     */
    public function getMessage()
    {
        return $this->message;
    }
}