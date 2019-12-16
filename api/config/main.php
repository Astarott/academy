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
            'enableStrictParsing' => true,
            'rules' => [
                ''=> 'v1/user/',
                'getallstudents' => 'v1/user/getallstudents',
                'getallstudentsinset' => 'v1/user/getallstudentsinset',

                'POST sendtoken' => 'v1/user/sendtoken',
                'POST send-mails' => 'v1/user/send-mails',
                'POST login' => 'v1/user/login',
                'POST changestatusteam' => 'v1/user/change-status-team',
                'POST disbandteam' => 'v1/user/disbandteam',

                'POST /v1/mail' => 'v1/user/signup',
                'POST /v1/changeteam' => 'v1/user/change-team',
                '/v1/signup' => 'v1/user/signup-second',
                'GET /v1/getsdudent' => 'v1/user/getuser',
                //FOR TESTS
                'POST v1/get-answer' => 'v1/test/getanswer',
                '/getresult' => 'v1/test/count-total-result',
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
