<?php
/**
 * File /Framework/Exception/SanitizerException.php contains SanitizerException class
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
     * @param string $code    Exception code.
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\SanitizerException SanitizerException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}