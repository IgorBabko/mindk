<?php

namespace Framework;

class Controller
{

    protected $controller;
    protected $action;
    protected $params;

    public function render($name, $params = array())
    {

        $name = VIEWS.$name;

        if (file_exists($name)) {
            $content = require $name;
        } else {
            $content = $name;
        }

        echo $content;
        // $content = \str_replace('{hello world}', $content, \file_get_contents(VIEWS . 'main_layout.html.php'));
        // echo $content;
        //echo $content;
        //echo 'hello world';
        //echo $content;
    }
}