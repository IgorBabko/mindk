<?php

use Framework\Autoloader;
use Framework\Application;

function info($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

//define('CORE',   __DIR__ . '/../framework');
define('CONFIG', __DIR__.'/../app/config/config.php');
define('ROUTES', __DIR__.'/../app/config/routes.php');
define('VIEWS', __DIR__.'/../src/Blog/views/');

require_once(__DIR__.'/../framework/Autoloader.php');

$loader = new Autoloader();
$loader->addNamespacePath("Blog\\Controller\\", __DIR__.'/../src/Blog/Controller/');

$loader->addNamespacePath('Framework\\', __DIR__.'/../framework/');
$loader->register();

/*echo '<pre>';
print_r(spl_autoload_functions());
echo '</pre>';
*/

$app = new Application(array('config' => CONFIG, 'routes' => ROUTES));
$app->run();
