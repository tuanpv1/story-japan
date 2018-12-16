<?php


$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en', /**  set target language to be en */
    'aliases' => [
        '@cat_image' => 'static/content_images',
        '@content_images' => 'staticdata/content_images',
        '@voucher_images' => 'staticdata/voucher_image',
        '@image_news' => 'staticdata/image_news',
        '@image_info' => 'staticdata/image_info',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\ApcCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'phptest102@gmail.com',
                'password' => '102phptest',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
    'timeZone' => 'Asia/Ho_Chi_Minh',
];


if (YII_ENV == 'prod' && extension_loaded('apcu')) {
    $config['components']['cache'] = [
        'class' => 'yii\caching\ApcCache',
        'useApcu' => true,
    ];
    $config['components']['session'] = [
        'class' => 'yii\redis\Session',
    ];
}
return $config;
