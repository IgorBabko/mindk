<?php
/**
 * File /framework/exception/JsonResponseException.php contains JsonResponseException class
 * to represent exceptions that can occur sending response in json form.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class JsonResponseException is used to represent exceptions that can occur
 * sending response in json form.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class JsonResponseException extends FrameworkException
{
    /**
     * JsonResponseException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\JsonResponseException JsonResponseException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}