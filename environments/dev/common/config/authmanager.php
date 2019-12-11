<?php
return [
'components' => [
    'authManager' => [
//        'class'           => 'yii\rbac\DbManager',
//        'itemTable'       => 'auth_item',
//        'itemChildTable'  => 'auth_item_child',
//        'assignmentTable' => 'auth_assignment',
//        'ruleTable'       => 'auth_rule',
        'class' => 'yii\rbac\PhpManager',
        'itemFile' => '@common/components/rbac/items/items.php',
        'assignmentFile' => '@common/components/rbac/items/assignments.php',
        'ruleFile' => '@common/components/rbac/rules.php',
        'defaultRoles' => ['admin', 'mentor', 'supervisor', 'student', 'lead', 'supermentor'],

//        'defaultRoles'    => ['guest'],// роль которая назначается всем пользователям по умолчанию
],
],
];
