<?php

ob_start();

use Framework\Application\App;
use Framework\Loader\Loader;

function info($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

define('CONF', __DIR__ . '/../app/config/config.php');
define('ROUTES', __DIR__ . '/../app/config/routes.php');
define('BLOG_VIEWS', __DIR__ . '/../src/blog/views/');
define('CMS_VIEWS', __DIR__ . '/../src/cms/views/');
define('BLOG_LAYOUT', __DIR__ . '/../src/blog/views/layout.html.php');
define('CMS_LAYOUT', __DIR__ . '/../src/cms/views/layout.html.php');

require_once(__DIR__ . '/../framework/application/AppInterface.php');
require_once(__DIR__ . '/../framework/application/App.php');
require_once(__DIR__ . '/../framework/loader/LoaderInterface.php');
require_once(__DIR__ . '/../framework/loader/Loader.php');

Loader::addNamespacePath('Blog\\', __DIR__ . '/../src/blog/');
Loader::addNamespacePath('Blog\\Controllers\\', __DIR__ . '/../src/blog/controllers/');
Loader::addNamespacePath('Blog\\Models\\', __DIR__ . '/../src/blog/models/');
Loader::addNamespacePath('CMS\\Controllers\\', __DIR__ . '/../src/cms/controllers/');
Loader::addNamespacePath('CMS\\Models\\', __DIR__ . '/../src/cms/models/');

App::init();
App::run();