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
    'components' => [
        'request' => [
//            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/xml' => 'yii\web\XmlParser',
            ],
        ],
//        'response' => [
//            'formatters' => [
//                'json' => [
//                    'class' => 'yii\web\JsonResponseFormat',
//                    'prettyPrint' => YII_DEBUG,
//                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
//                ],
//            ],
//        ],
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

                  '' => 'site/index',
                  'auth' => 'site/login',

                  'mail' => 'user/send-mail',

                  '<_c:[\w-]+>' => '<_c>/index',
                  '<_c:[\w-]+>/<id:\d+>' => '<_c>/view',
                  '<_c:[\w-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
                [

                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'prefix' => 'api', //api будет доступен по url, начинающимся с /api/test
                ],
            ],
        ],

    ],
    'params' => $params,
];
