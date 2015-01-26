<?php
/**
 * File /framework/exception/ControllerException.php contains ControllerException class
 * to represent exceptions that might occur inside of all app controllers.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ControllerException is used to represent exceptions
 * that might occur inside of all app controllers.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ControllerException extends FrameworkException
{
    /**
     * ControllerException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return \Framework\Exception\ControllerException ControllerException instance.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}