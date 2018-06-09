<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name'=>'SGT',
    // set target language to be Spanish
    'language' => 'es',

    // set source language to be English
//    'sourceLanguage' => 'en',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'cookieValidationKey' => 'UJgqjPGCLE05wVUyL3Ts2z-j7i_S2IRu',
            'cookieValidationKey' => 'UJgqjPGCLE05wVUyL3Ts2z-j7i_S2IRu',
            'parsers'  => ['application/json' => 'yii\web\JsonParser'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\CacheSession',
        ],
        'user' => [
            'identityClass' => 'app\modules\administracion\models\AdmUser',
            'enableAutoLogin' => true,
//            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '127.0.0.1',
            ],
        ],        /*
   'mailer' => [
       'class' => 'yii\swiftmailer\Mailer',
       'transport' => [
           'class' => 'Swift_SmtpTransport',
           'host' => 'localhost',
           'username' => 'Administrator',
           'password' => 'yopt85',
           'port' => '587',
           'encryption' => 'tls',
       ],
   ],
   'mailer' => [
       'class' => 'yii\swiftmailer\Mailer',
       // send all mails to a file by default. You have to set
       // 'useFileTransport' to false and configure a transport
       // for the mailer to send real emails.
       'useFileTransport' => true,


   ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'baseUrl' => 'http://localhost:8080/',
            'rules' => [
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'rd' => 'app\modules\rd\RD',
        'administracion' => 'app\modules\administracion\Administracion',
//        'administracion' => [
//            'class' => 'app\modules\administracion\Administracion',
//        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
