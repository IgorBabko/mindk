<?php

namespace Framework\Exception;

class ResponseException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}