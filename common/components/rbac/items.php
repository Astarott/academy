<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'view' => [
        'type' => 2,
    ],
    'update' => [
        'type' => 2,
    ],
    'delete' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'logout',
            'error',
            'index',
            'view',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'delete',
            'supermentor',
        ],
    ],
    'student' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'lead',
        ],
    ],
    'lead' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'update',
            'guest',
        ],
    ],
    'supervisor' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'student',
        ],
    ],
    'mentor' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'student',
        ],
    ],
    'supermentor' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'guest',
            'supervisor',
            'mentor',
        ],
    ],
];
