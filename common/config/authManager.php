<?php

return [
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['admin', 'mentor', 'supervisor', 'student', 'lead', 'supermentor'],
            'itemFile' => 'common/components/rbac/items/items.php',
            'assignmentFile' => 'common/components/rbac/items/assignments.php',
            'ruleFile' => 'common/components/rbac/items/rules.php'
            //  'defaultRoles' => ['admin', 'BRAND', 'TALENT'], // Здесь нет роли "guest", т.к. эта роль виртуальная и не присутствует в модели UserExt
        ],
    ]
];