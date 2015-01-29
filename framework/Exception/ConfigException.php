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
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object ConfigException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}