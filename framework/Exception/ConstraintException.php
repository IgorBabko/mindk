<?php
/**
 * File /framework/exception/ConstraintException.php contains ConstraintException class
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
     * @param  int    $code    Exception code
     * @param  string $message Exception message.
     *
     * @return object ConstraintException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}