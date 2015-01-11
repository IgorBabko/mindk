<?php
/**
 * File /framework/exception/RouterException.php contains RouterException class
 * to represent exceptions related to router.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class RouterException is used to represent exceptions
 * that might happen while searching route.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouterException extends FrameworkException
{
    /**
     * RouterException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\RouterException RouterException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}