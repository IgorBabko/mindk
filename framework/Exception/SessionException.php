<?php

namespace Framework\Exception;

class SessionException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}