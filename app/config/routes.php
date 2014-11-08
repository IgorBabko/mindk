<?php

return array(

    'testRoute1'            => array(
        'pattern'    => '/testRoute1/:id/edit',
        'controller' => 'Blog\\Controller\\TestRoute2Controller',
        'action'     => 'edit',
        '_requirements' => array('_method' => 'GET', 'id' => '\d+')
    ),

    'testRoute2'        => array(
        'pattern'    => '/testRoute2/:id/:name',
        'controller' => 'Blog\\Controller\\MyController',
        'action'     => 'index',
        '_requirements' => array('_method' => 'GET', 'id' => '\d+', 'name' => '\w+')
    ),
    'hello'          => array(
        'pattern'    => '/hello',
        'controller' => 'Blog\\Controller\\HelloController',
        'action'     => 'index',
        'security'   => array('niko', 'bellic'),
        '_requirements' => array('_method' => 'GET', 'id' => '\d+')
    ),
    'home'           => array(
        'pattern'    => '/',
        'controller' => 'Blog\\Controller\\HelloController',  //PostController,
        'action'     => 'index'
    ),
    'testredirect'   => array(
        'pattern'    => '/test_redirect',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'redirect',
    ),
    'test_json' => array(
        'pattern'    => '/test_json',
        'controller' => 'Blog\\Controller\\TestController',
        'action'     => 'getJson',
    ),
    'signin'         => array(
        'pattern'    => '/signin',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'signin'
    ),
    'login'          => array(
        'pattern'    => '/login',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'login'
    ),
    'logout'         => array(
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controller\\SecurityController',
        'action'     => 'logout'
    ),
    'update_profile' => array(
        'pattern'       => '/profile',
        'controller'    => 'CMS\\Controller\\ProfileController',
        'action'        => 'update',
        '_requirements' => array(
            '_method' => 'POST'
        )
    ),
    'profile'        => array(
        'pattern'    => '/profile',
        'controller' => 'CMS\\Controller\\ProfileController',
        'action'     => 'get'
    ),
    'add_post'       => array(
        'pattern'    => '/posts/add',
        'controller' => 'Blog\\Controller\\PostController',
        'action'     => 'add',
        'security'   => array('ROLE_USER'),
    ),
    'show_post'      => array(
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\Controller\\PostController',
        'action'        => 'show',
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'edit_post'      => array(
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\Controller\\BlogController',
        'action'        => 'edit',
        '_requirements' => array(
            'id'      => '\d+',
            '_method' => 'POST'
        )
    )
);