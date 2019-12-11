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
//            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/xml' => 'yii\web\XmlParser',
            ],
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the frontend
//            'name' => 'advanced-frontend',
//        ],
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

                  '' => 'v1/site/index',
//                  'auth' => 'site/login',
//
                  'POST /v1/mail' => 'v1/user/signup',
                  '/v1/signup' => 'v1/user/signup-second',
//                  '<_c:[\w-]+>' => '<_c>/index',
//                  '<_c:[\w-]+>/<id:\d+>' => '<_c>/view',
//                  '<_c:[\w-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',

                [
//                    'class' => yii\rest\UrlRule::class,
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
//                    'prefix' => 'api',
                    'extraPatterns' => [
                        'GET /' => 'index',
                        'POST /v1/mail' => 'signup',
                        'POST /v1/signup' => 'signup-second',
                    ],
                ],
//                [
//                    'class' => 'yii\rest\UrlRule',
//                    'controller' => ['v1/site'],
//                    'extraPatterns' => [
//                        'GET' => 'index',
//                    ],
//                ],
            ],
        ],

    ],
    'params' => $params,
];
