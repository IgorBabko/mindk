<?php

namespace Framework\Exception;

require_once('FrameworkException.php');

class LoaderException extends FrameworkException
{
    function __construct($message)
    {
        $this->message = $message;
    }
}