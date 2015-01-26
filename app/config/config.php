<?php

return array(
    'mode'                    => 'dev',
    'routes'                  => include('routes.php'),
    'blog_main_layout'        => __DIR__.'/../../src/blog/views/layout.html.php',
    'cms_main_layout'         => __DIR__.'/../../src/cms/views/layout.html.php',
    'error_500'               => __DIR__.'/../../src/blog/views/error.html.php',
    'user_session'            => 'user_session',
    'session_cookie_lifetime' => 2592000,
    'token'                   => 'token',
    'remember'                => 'remember',
    'pdo'                     => array(
        'host'     => 'localhost',
        'engine'   => 'mysql',
        'dbname'   => 'mindk',
        'user'     => 'root',
        'password' => 'root',
        'charset'  => 'utf8'
    ),
    'security'                => array(
        'user_class'  => 'Blog\\Models\\User',
        'login_route' => 'login'
    ),
    'pagination'              => array(
        'items_per_page' => 4,
        'visible_pages'  => 3
    )
);