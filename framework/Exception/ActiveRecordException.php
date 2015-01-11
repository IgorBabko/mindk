<?php
/**
 * File /framework/exception/ActiveRecordException.php contains ActiveRecordException class
 * to represent exceptions related to data models.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ActiveRecordException is used to represent exceptions
 * that might happen working with data models.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ActiveRecordException extends FrameworkException
{
    /**
     * ActiveRecordException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ActiveRecordException ActiveRecordException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}