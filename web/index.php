<?php

use Framework\Application;

function info($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

require_once(__DIR__ . '/../Framework/Application.php');

$application = Application::instantiate();
$application->run();

