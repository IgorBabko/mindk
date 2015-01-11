<?php
/**
 * File /framework/exception/FormBuilderException.php contains FormBuilderException class
 * to represent exceptions that can occur while creating forms.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class FormBuilderException is used to represent exceptions
 * that can occur while creating forms.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FormBuilderException extends FrameworkException
{
    /**
     * FormBuilderException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\FormBuilderException FormBuilderException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}