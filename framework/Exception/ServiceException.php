<?php

namespace Framework\Exception;

class ServiceException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}