<?php

use Framework\Loader;

#define('CORE_PATH', __DIR__ . '/../framework');
define('CONFIG', __DIR__.'/../app/config/config.php');
define('ROUTES', __DIR__.'/../app/config/routes.php');
define('VIEWS', __DIR__.'/../src/Blog/views/');

require_once(__DIR__.'/../framework/Loader.php');

Loader::addNamespacePath("Blog\\Controller\\", __DIR__.'/../src/Blog/Controller/');
Loader::addNamespacePath('Blog\\Model\\',	   __DIR__.'/../src/Blog/Model/');
Loader::addNamespacePath('Framework\\', 	   __DIR__.'/../framework/');


$app = Loader::core('Application', array('config' => CONFIG, 'routes' => ROUTES));
$app->run();