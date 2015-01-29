<?php
/**
 * File /framework/exception/SanitizerException.php contains SanitizerException class
 * to represent exceptions related to sanitization.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class SanitizerException is used to represent exceptions
 * that might happen during sanitization.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SanitizerException extends FrameworkException
{
    /**
     * SanitizerException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object SanitizerException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}