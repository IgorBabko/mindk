<?php
/**
 * File /framework/exception/ServiceException.php contains ServiceException class
 * to represent exceptions related to DI.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ServiceException is used to represent exceptions
 * that might happen while resolving dependencies for particular service.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ServiceException extends FrameworkException
{
    /**
     * ServiceException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ServiceException ServiceException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}