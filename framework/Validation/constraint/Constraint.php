<?php
/**
 * File /framework/validation/constraint/Constraint.php contains Constraint superclass
 * for all validation constraints.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

/**
 * Class Constraint is a superclass for all validation constraints.
 * Default implementation of {@link ConstraintInterface}.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
abstract class Constraint implements ConstraintInterface
{
    /**
     * @var string $_message Error message for particular constraint
     */
    protected $_message;

    /**
     * Constructor which sets error message for particular constraint.
     *
     * @param  string $message Error message.
     *
     * @return object Constraint.
     */
    public function __construct($message = '')
    {
        $this->_message = $message;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function validate($value);

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->_message;
    }
}