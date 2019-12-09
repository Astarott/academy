<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=academy',
            'username' => 'test_user',
            'password' => 'qwerty',
            'charset' => 'utf8',
        ]
    ]
];
