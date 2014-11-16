<?php

namespace Framework\Exception;

class ValidatorException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}