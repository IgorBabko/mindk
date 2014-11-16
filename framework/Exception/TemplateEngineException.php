<?php

namespace Framework\Exception;

class TemplateEngineException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}