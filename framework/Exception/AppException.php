<?php
/**
 * File /framework/exception/AppException.php contains ApplicationException class
 * to represent common exceptions in application.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ApplicationException is used to represent common exceptions in application.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ApplicationException extends FrameworkException
{
    /**
     * ApplicationException constructor.
     *
     * @param  string $code    exception code
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ApplicationException ApplicationException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}