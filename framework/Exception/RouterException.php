<?php

namespace Framework\Exceptions;

class RouterException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}