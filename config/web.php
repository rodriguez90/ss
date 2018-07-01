<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db2 = require __DIR__ . '/db2.php';

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
            'viewPath' => '@app/mail',
//            'viewPath' => '@app\mail\layouts',
//            'viewPath' => '@app/mail/layouts',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '127.0.0.1',
//                'host' => 'smtp.gmail.com',
//                'username' => 'rodriguez90@gmail.com',
//                'password' => 'fidenciolilopo90/*',
//                'port' => '587'
                //                'encryption' => 'tls
//                'username' => 'Administrator',
//                'password' => 'Root*2018',
//                'port' => '25', // Port 25 is a very common port too
            ],
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
        'db' =>$db,
        'db2'=>$db2,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'showScriptName' => false,
           'baseUrl' => 'http://localhost:8080/sgt/',
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
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
        ],
    ],
    'modules' => [
        'rd' => 'app\modules\rd\RD',
        'administracion' => 'app\modules\administracion\Administracion',
    ],
//    'modules' => [
//        'rd' => [
//            'class' => 'app\modules\rd\RD',
//        ],
//        'administracion' => [
//            'class' => 'app\modules\administracion\Administracion',
//        ],
//    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
