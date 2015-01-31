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
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object ActiveRecordException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}