<?php

use Framework\Application;
use Framework\Loader;

function info($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

require_once(__DIR__ . '/../Framework/Application.php');
require_once('../framework/Loader.php');

Loader::addNamespacePath('Blog\\Controller\\', __DIR__ . '/../src/Blog/Controller/');


$application = Application::instantiate();
$application->run();

