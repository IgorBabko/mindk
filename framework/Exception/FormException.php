<?php
/**
 * File /framework/exception/FormException.php contains FormException class
 * to represent exceptions that can occur while handling forms.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class FormException is used to represent exceptions
 * that can occur while handling forms.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FormException extends FrameworkException
{
    /**
     * FormException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\FormException FormException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}