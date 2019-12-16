<?php
return [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_HOST'),
                'username' => env ('MAIL_USERNAME'),
                'password' => env ('MAIL_PASSWORD'),
                'port' => '25',
                'encryption' => 'tls',
            ]
        ]
    ]
];
