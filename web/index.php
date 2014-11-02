<?php

use Framework\Loader;

function info($obj) {
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
}

define('CORE',   __DIR__ . '/../framework');
define('CONFIG', __DIR__ . '/../app/config/config.php');
define('ROUTES', __DIR__ . '/../app/config/routes.php');
define('VIEWS',  __DIR__ . '/../src/Blog/views/');

require_once(__DIR__ . '/../framework/Loader.php');

Loader::addNamespacePath("Blog\\Controller\\", __DIR__ . '/../src/Blog/Controller/');
Loader::addNamespacePath('Blog\\Model\\',	   __DIR__ . '/../src/Blog/Model/');
Loader::addNamespacePath('Framework\\', 	   __DIR__ . '/../framework/');


$app = Loader::loadCoreComponent('Application', array('config' => CONFIG, 'routes' => ROUTES));
$app->run();

info($_SERVER);