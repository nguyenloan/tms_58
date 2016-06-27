<?php
return [
    'user' => [
        'login_redirect_path' => '/users',
        'rule' => [
            'name_max' => 50,
            'email_max' => 80,
            'password_min' => 6,
            'image_size' => 2000,
        ],
        'avatar_path' => '/images',
        'default_avatar' => '/images/default.png',
        'follow' => 'follow',
        'unfollow' => 'unfollow',
    ],
    'subject' => [
        'rule' => [
            'name_max' => 120,
        ],
    ],
    'layout' => [
        'general' => 'layout.layout',
    ],
    'base_repository' => [
        'filter' => [],
        'attributes' => null,
        'order_by' => ['key' => "id", 'aspect' => 'DESC'],
        'limit' => 10,
        'buttons' => [
            'create' => [
                'name' => 'create',
                'alert' => '',
                'check' => '',
                'url' => 'create',
            ],
            'destroy' => [
                'name' => 'delete',
                'alert' => 'Delete these items?',
                'check' => 'Choose item before deleting',
                'url' => 'destroy',
                'param' => 1,
            ]
        ],
    ],
];
