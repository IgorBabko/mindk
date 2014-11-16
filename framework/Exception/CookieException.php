<?php

namespace Framework\Exception;

class CookieException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}