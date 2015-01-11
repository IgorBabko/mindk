<?php
/**
 * File /framework/exception/ResponseException.php contains ResponseException class
 * to represent exceptions related to http response.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ResponseException is used to represent exceptions
 * that might happen working with http response.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ResponseException extends FrameworkException
{
    /**
     * ResponseException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ResponseException ResponseException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}