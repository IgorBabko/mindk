<?php
/**
 * File /framework/exception/ResponseRedirectException.php contains ResponseRedirectException class
 * to represent exceptions that can occur while redirecting.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ResponseRedirectException is used to represent exceptions
 * that might happen while redirecting.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ResponseRedirectException extends FrameworkException
{
    /**
     * ResponseRedirectException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return \Framework\Exception\ResponseRedirectException ResponseRedirectException instance.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}