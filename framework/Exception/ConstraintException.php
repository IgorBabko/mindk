<?php
/**
 * File /Framework/Exception/ConstraintException.php contains ConstraintException class
 * to represent exceptions of validation constraints.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ConstraintException is used to represent exceptions of validation constraints.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ConstraintException extends FrameworkException
{
    /**
     * ConstraintException constructor.
     *
     * @param string $code    Exception code
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\ConstraintException ConstraintException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}