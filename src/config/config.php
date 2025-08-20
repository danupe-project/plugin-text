<?php
$prefix = danupe()->plugin('user', 'admin')->getPrefix();

return [
    'navigation' => [
        '/' . $prefix . '/texts' => ['title' => 'Text', 'icon' => 'fa-solid fa-quote-right', 'sort' => 9000, 'parent' => '', 'roles' => ['user','admin']],
        '/' . $prefix . '/texts/create' => ['title' => 'Create Text', 'icon' => 'fa-solid fa-quote-right', 'sort' => 9001, 'parent' => '/' . $prefix . '/texts', 'roles' => ['user','admin']],
    ],

    'routes' => [
        ################# text start #################
        '/' . $prefix . '/texts' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'index',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/texts/table' => [
            'controller' => 'Danupe\\Plugin\\Text\\Controllers\\TextController',
            'action' => 'table',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user','admin'],
        ],
        '/' . $prefix . '/texts/create' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'create',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/texts/edit/{id}' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'edit',
            'middlewares' => ['auth'],
            'method' => 'GET',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/texts/create_post' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'create_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/texts/update_post' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'update_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
        '/' . $prefix . '/texts/delete_post' => [
            'controller' => 'Danupe\Plugin\Text\Controllers\TextController',
            'action' => 'delete_post',
            'middlewares' => ['auth'],
            'method' => 'POST',
            'roles' => ['user', 'admin'],
        ],
        ################# text end #################
    ]
];
