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
        'avatar_path' => '/upload/',
        'default_avatar' => '/images/default.png',
        'follow' => 'follow',
        'unfollow' => 'unfollow',
        'activity_limit' => 15,
        'role' => [
            'trainee' => 0,
            'supervisor' => 1,
        ]
    ],
    'subject' => [
        'rule' => [
            'name_max' => 120,
        ],
        'status' => [
            'start' => 0,
            'finish' => 1,
        ]
    ],
    'task' => [
        'rule' => [
            'name_max' => 120,
        ],
    ],
    'course' => [
        'rule' => [
            'name_max' => 200,
        ],
        'limit' => 4,
    ],
    'user_course' => [
        'status' => [
            'start' => 0,
            'finish' => 1,
        ],
    ],
    'layout' => [
        'general' => 'layout.layout',
        'managements' => [
            [
                'name' => 'Course',
                'url' => 'admin.courses.index',
            ],
            [
                'name' => 'Subject',
                'url' => 'admin.subjects.index',
            ],
            [
                'name' => 'Trainee',
                'url' => 'admin.trainees.index',
            ],
        ]
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
    'user_task' => [
        'status' => [
            'training' => 0,
            'finish' => 1,
        ],
    ],
    'activity' => [
        'type' => [
            'start_course' => 0,
            'finish_course' => 1,
            'start_subject' => 2,
            'finish_subject' => 3,
        ],
    ],
];
