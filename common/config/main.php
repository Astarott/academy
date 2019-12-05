<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/authManager.php',
    [
        'aliases' => [
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
        ],
        'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
        'components' => [
            'cache' => [
                'class' => 'yii\caching\FileCache',
            ],
        ],
    ]);