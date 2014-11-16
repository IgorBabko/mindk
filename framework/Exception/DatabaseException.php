<?php

namespace Framework\Exception;

class DatabaseException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}