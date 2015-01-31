<?php

return array(
    'mode'                    => 'dev',
    'routes'                  => include('routes.php'),
    'blog_main_layout'        => __DIR__.'/../../src/blog/views/layout.html.php',
    'cms_main_layout'         => __DIR__.'/../../src/cms/views/layout.html.php',
    'error_500'               => __DIR__.'/../../src/blog/views/error.html.php',
    'session_cookie_lifetime' => 2592000,
    'remember'                => 'remember',
    'pdo'                     => array(
        'host'     => 'localhost',
        'engine'   => 'mysql',
        'dbname'   => 'mindk',
        'user'     => 'igor',
        'password' => 'igor',
        'charset'  => 'utf8'
    ),
    'pagination'              => array(
        'items_per_page' => 3,
        'visible_pages'  => 4
    )
);