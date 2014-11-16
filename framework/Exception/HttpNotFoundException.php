<?php

namespace Framework\Exception;

class HttpNotFoundException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}