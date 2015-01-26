<?php

return array(

    /***************************** Blog *************************/


    /* pages: home, posts, post, comment, show, feedback, dashboard */
    'home'            => array(
        'pattern'    => '/',
        'controller' => 'Blog\\Controllers\\PostController',
        'action'     => 'index'
    ),
    'posts'           => array(
        'pattern'       => '/posts/{categoryId}/{pageId}',
        'controller'    => 'Blog\\Controllers\\PostController',
        'action'        => 'index',
        '_requirements' => array(
            'categoryId' => 'search|\d+',
            'pageId'     => '\d+'
        )
    ),
    'post'            => array(
        'pattern'       => '/posts/{id}',
        'controller'    => 'Blog\\Controllers\\PostController',
        'action'        => 'show',
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'comment'         => array(
        'pattern'    => '/comment/add',
        'controller' => 'Blog\\Controllers\\CommentController',
        'action'     => 'add',
        '_requirements' => array(
            '_method' => 'POST',
            '_ajax'
        )
    ),
    'about'           => array(
        'pattern'    => '/about',
        'controller' => 'Blog\\Controllers\\PageController',
        'action'     => 'about'
    ),
    'feedback'        => array(
        'pattern'    => '/feedback',
        'controller' => 'Blog\\Controllers\\PageController',
        'action'     => 'feedback'
    ),
    'dashboard'       => array(
        'pattern'    => '/dashboard',
        'controller' => 'CMS\\Controllers\\PageController',
        'action'     => 'dashboard'
    ),
    /* end pages */

    /* profile management: signup, login, profile, change_password, logout */
    'signup'          => array(
        'pattern'    => '/signup',
        'controller' => 'Blog\\Controllers\\UserController',
        'action'     => 'signup'
    ),
    'login'           => array(
        'pattern'    => '/login',
        'controller' => 'Blog\\Controllers\\UserController',
        'action'     => 'login'
    ),
    'update'  => array(
        'pattern'    => '/update',
        'controller' => 'Blog\\Controllers\\UserController',
        'action'     => 'update'
    ),
    'change_password' => array(
        'pattern'    => '/change_password',
        'controller' => 'Blog\\Controllers\\UserController',
        'action'     => 'changePassword'
    ),
    'logout'          => array(
        'pattern'    => '/logout',
        'controller' => 'Blog\\Controllers\\UserController',
        'action'     => 'logout'
    ),
    /* end profile management */


    /**************************** CMS ***************************/


    /* posts: show all, add, edit, delete */
    'show_posts'      => array(
        'pattern'       => '/posts/{pageId}/show',
        'controller'    => 'CMS\\Controllers\\PostController',
        'action'        => 'index',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'pageId' => '\d+'
        )
    ),
    'add_post'        => array(
        'pattern'    => '/posts/add',
        'controller' => 'CMS\\Controllers\\PostController',
        'action'     => 'add',
        'security'   => array('ADMIN')
    ),
    'edit_post'       => array(
        'pattern'       => '/posts/{id}/edit',
        'controller'    => 'CMS\\Controllers\\PostController',
        'action'        => 'edit',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'delete_post'     => array(
        'pattern'       => '/posts/{id}/delete',
        'controller'    => 'CMS\\Controllers\\PostController',
        'action'        => 'delete',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id'     => '\d+'
        )
    ),
    /* end posts */

    /* categories: show all, add, edit, delete */
    'show_categories' => array(
        'pattern'       => '/categories/{pageId}/show',
        'controller'    => 'CMS\\Controllers\\CategoryController',
        'action'        => 'index',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'pageId' => '\d+'
        )
    ),
    'add_category'    => array(
        'pattern'    => '/categories/add',
        'controller' => 'CMS\\Controllers\\CategoryController',
        'action'     => 'add',
        'security'   => array('ADMIN')
    ),
    'edit_category'   => array(
        'pattern'       => '/categories/{id}/edit',
        'controller'    => 'CMS\\Controllers\\CategoryController',
        'action'        => 'edit',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'delete_category' => array(
        'pattern'       => '/categories/{id}/delete',
        'controller'    => 'CMS\\Controllers\\CategoryController',
        'action'        => 'delete',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    /* end categories */

    /* comments: show all, add, show, edit, delete */
    'show_comments'   => array(
        'pattern'       => '/comments/{pageId}/show',
        'controller'    => 'CMS\\Controllers\\CommentController',
        'action'        => 'index',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'pageId' => '\d+'
        )
    ),
    'add_comment'     => array(
        'pattern'    => '/comments/add',
        'controller' => 'CMS\\Controllers\\CommentController',
        'action'     => 'add',
        'security'   => array('ADMIN')
    ),
    'show_comment'    => array(
        'pattern'       => '/comment/show/{id}',
        'controller'    => 'CMS\\Controllers\\CommentController',
        'action'        => 'show',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+',
        )
    ),
    'edit_comment'    => array(
        'pattern'       => '/comments/{id}/edit',
        'controller'    => 'CMS\\Controllers\\CommentController',
        'action'        => 'edit',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+',
        )
    ),
    'delete_comment'  => array(
        'pattern'       => '/comments/{id}/delete',
        'controller'    => 'CMS\\Controllers\\CommentController',
        'action'        => 'delete',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+',
            '_method' => 'POST'
        )
    ),
    /* end comments */

    /* users: show all, show, delete */
    'show_users'      => array(
        'pattern'       => '/users/{pageId}/show',
        'controller'    => 'CMS\\Controllers\\UserController',
        'action'        => 'index',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'pageId' => '\d+'
        )
    ),
    'show_user'       => array(
        'pattern'       => '/user/show/{id}',
        'controller'    => 'CMS\\Controllers\\UserController',
        'action'        => 'show',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+',
        )
    ),
    'delete_user'     => array(
        'pattern'       => '/users/{id}/delete',
        'controller'    => 'CMS\\Controllers\\UserController',
        'action'        => 'delete',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id'     => '\d+',
            '_method' => 'POST'
        )
    ),
    /* end users */

    /* roles: show all, add, edit, delete */
    'show_roles'      => array(
        'pattern'       => '/roles/{pageId]/show',
        'controller'    => 'CMS\\Controllers\\RoleController',
        'action'        => 'show',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'pageId' => '\d+'
        )
    ),
    'add_role'        => array(
        'pattern'    => '/roles/add',
        'controller' => 'CMS\\Controllers\\RoleController',
        'action'     => 'add',
        'security'   => array('ADMIN')
    ),
    'edit_role'       => array(
        'pattern'       => '/role/{id}/edit',
        'controller'    => 'CMS\\Controllers\\RoleController',
        'action'        => 'edit',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+'
        )
    ),
    'delete_role'     => array(
        'pattern'       => '/role/{id}/delete',
        'controller'    => 'CMS\\Controllers\\RoleController',
        'action'        => 'delete',
        'security'      => array('ADMIN'),
        '_requirements' => array(
            'id' => '\d+',
            '_method' => 'POST'
        )
    )
    /* end roles */
);