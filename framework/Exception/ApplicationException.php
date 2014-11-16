<?php

namespace Framework\Exception;

class ApplicationException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}