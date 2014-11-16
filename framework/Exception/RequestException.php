<?php

namespace Framework\Exception;

class RequestException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}