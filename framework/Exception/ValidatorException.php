<?php
/**
 * File /Framework/Exception/ValidatorException.php contains ValidatorException class
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
 * that might happen while making validation.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ValidatorException extends FrameworkException
{
    /**
     * ValidatorException constructor.
     *
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\ValidatorException ValidatorException instance.
     */
    function __construct($message)
    {
        $this->message = $message;
    }
}