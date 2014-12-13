<?php
/**
 * File /Framework/Exception/LoaderException.php contains LoaderException class
 * to represent exceptions related to class loader.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

require_once('FrameworkException.php');

/**
 * Class LoaderException is used to represent exceptions
 * that might happen while loading classes.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class LoaderException extends FrameworkException
{
    /**
     * LoaderException constructor.
     *
     * @param string $code    Exception code.
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\LoaderException LoaderException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}