<?php
/**
 * File /Framework/Exception/RouterException.php contains RouterException class
 * to represent exceptions related to router.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exceptions;

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
     * @param string $message Exception message.
     *
     * @return \Framework\Exceptions\RouterException RouterException instance.
     */
    function __construct($message)
    {
        $this->message = $message;
    }
}