<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'controllerNamespace' => 'api\controllers',

    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\MVPModule',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\SecondModule',
        ]
    ],

    'components' => [
        'request' => [

            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/xml' => 'yii\web\XmlParser',
            ],
        ],

        'user' => [
            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
         ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [


                //FOR Bulat admin actions
                '/get-all-students' => 'v1/user/get-all-students',
                '/get-all-students-in-set' => 'v1/user/get-all-students-in-set',
                '/v1/change-team' => 'v1/user/change-team',
                '/v1/get-student' => 'v1/user/get-user',
                '/send-mails' => 'v1/user/send-mails',
                '/change-status-team' => 'v1/user/change-status-team',
                '/disband-team' => 'v1/user/disband-team',
                '' => 'v1/user/index',


                //FOR user registration and authorization
                '/v1/mail' => 'v1/user/sign-up',
                '/v1/sign-up' => 'v1/user/sign-up-second',
                '/login' => 'v1/user/login',
                '/send-token' => 'v1/user/send-token',


                //FOR user tests
                '/v1/get-answer' => 'v1/test/get-answer',
                '/get-result' => 'v1/test/count-total-result',
                '/v1/start-test' => 'v1/test/start-test',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'extraPatterns' => [
                    ],
                ],

            ],
        ],

    ],
    'params' => $params,
];
