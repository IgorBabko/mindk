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
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object JsonResponseException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}