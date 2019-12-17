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
                '/get-all-students-inset' => 'v1/user/get-all-students-inset',
                '/v1/changeteam' => 'v1/user/change-team',
                '/v1/getsdudent' => 'v1/user/getuser',
                '/send-mails' => 'v1/user/send-mails',
                '/changestatusteam' => 'v1/user/change-status-team',
                '/disbandteam' => 'v1/user/disbandteam',
                '' => 'v1/user/index',


                //FOR user registration and authorization
                '/v1/mail' => 'v1/user/signup',
                '/v1/signup' => 'v1/user/signup-second',
                '/login' => 'v1/user/login',
                '/sendtoken' => 'v1/user/sendtoken',


                //FOR user tests
                '/v1/get-answer' => 'v1/test/getanswer',
                '/getresult' => 'v1/test/count-total-result',
                '/v1/start-test' => 'v1/test/start-test',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'extraPatterns' => [
                        'POST /v1/mail' => 'signup',
                        'POST /v1/signup' => 'signup-second',
                    ],
                ],

            ],
        ],

    ],
    'params' => $params,
];
