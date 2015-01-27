<?php

return array(
    'mode'        => 'dev',
    'routes'      => include('routes.php'),
    'main_layout' => __DIR__.'/../../src/blog/views/layout.html.php',
    'error_500'   => __DIR__.'/../../src/blog/views/500.html.php',
    'pdo'         => array(
        'host'     => 'localhost',
        'engine'   => 'mysql',
        'dbname'   => 'igor',
        'user'     => 'root',
        'password' => 'root',
        'charset'  => 'utf8'
    ),
    'security'    => array(
        'user_class'  => 'Blog\\Models\\User',
        'login_route' => 'login'
    )
);