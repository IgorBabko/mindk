<?php
/**
 * File /framework/exception/ValidatorException.php contains ValidatorException class
 * to represent exceptions related to validation.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ValidatorException is used to represent exceptions
 * that might happen during validation.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ValidatorException extends FrameworkException
{
    /**
     * ValidatorException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ValidatorException ValidatorException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}