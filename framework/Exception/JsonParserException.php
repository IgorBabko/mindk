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
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object JsonParserException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}