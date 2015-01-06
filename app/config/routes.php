<?php

return array(

    'error'            => array(
        'pattern'    => '',
        'controller' => 'Framework\\ErrorController',
        'action'     => 'index',
        '_requirements' => array()
    ),

    'test'            => array(
        'pattern'    => '/test/{id}/edit',
        'controller' => 'Blog\\Controllers\\HelloController',
        'action'     => 'edit',
        '_requirements' => array('_method' => 'GET', 'id' => '\d+')
    ),

    'test2'        => array(
        'pattern'    => '/test2/{id}/{name}',
        'controller' => 'Blog\\Controllers\\HelloController',
        'action'     => 'index',
        '_requirements' => array('_method' => 'GET', 'id' => '\d+', 'name' => '[123]*')
    ),
    'hello'          => array(
        'pattern'    => '/hello',
        'controller' => 'Blog\\Controllers\\HelloController',
        'action'     => 'index',
        '_requirements' => array('_method' => 'GET', 'id' => '\d+')
    ),
    'home'           => array(
        'pattern'    => '/',
        'controller' => 'Blog\\Controllers\\HelloController',  //PostController,
        'action'     => 'index'
    ),
    'testredirect'   => array(
        'pattern'    => '/test_redirect',
        'controller' => 'Blog\\Controllers\\TestController',
        'action'     => 'redirect',
    ),
    'test_json' => array(
        'pattern'    => '/test_json',
        'controller' => 'Blog\\Controllers\\TestController',
        'action'     => 'getJson',
    ),
    'signin'         => array(
        'pattern'    => '/signin',
        'controller' => 'Blog\\Controllers\\SecurityController',
        'action'     => 'signin'
    ),
    'login'          => array(
        'pattern'    => '/login',
        'controller' => 'Blog\\Controllers\\SecurityController',
        'action'     => 'login'
    ),
    'logout'         => array(
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controllers\\SecurityController',
        'action'     => 'logout'
    ),
    'update_profile' => array(
        'pattern'       => '/profile',
        'controller'    => 'CMS\\Controllers\\ProfileController',
        'action'        => 'update',
        '_requirements' => array(
            '_method' => 'POST'
        )
    ),
    'profile'        => array(
        'pattern'    => '/profile',
        'controller' => 'CMS\\controller\\ProfileController',
        'action'     => 'get'
    ),
    'add_post'       => array(
        'pattern'    => '/posts/add',
        'controller' => 'Blog\\controller\\PostController',
        'action'     => 'add',
        'security'   => array('ROLE_USER'),
    ),
    'show_post'      => array(
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\controller\\PostController',
        'action'        => 'show',
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'edit_post'      => array(
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\controller\\BlogController',
        'action'        => 'edit',
        '_requirements' => array(
            'id'      => '\d+',
            '_method' => 'POST'
        )
    )
);