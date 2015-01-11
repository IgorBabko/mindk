<?php
/**
 * File /framework/exception/ConfigException.php contains ConfigException class
 * to represent exceptions related to app configurations.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ConfigException is used to represent exceptions
 * related to app configurations.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ConfigException extends FrameworkException
{
    /**
     * ConfigException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\ConfigException ConfigException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}