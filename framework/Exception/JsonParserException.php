<?php
/**
 * File /framework/exception/JsonParserException.php contains JsonParserException class
 * to represent exceptions that can occur while working with json format.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class JsonParserException is used to represent exceptions that can occur while working with json format.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class JsonParserException extends FrameworkException
{
    /**
     * JsonParserException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\JsonParserException JsonParserException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}