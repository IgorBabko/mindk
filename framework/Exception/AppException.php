<?php
/**
 * File /framework/exception/AppException.php contains AppException class
 * to represent common exceptions in application.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class AppException is used to represent common exceptions in application.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class AppException extends FrameworkException
{
    /**
     * AppException constructor.
     *
     * @param  string $code    exception code
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\AppException AppException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}