<?php

// Sybase Data Base Connection !!! WORK

return [
    'class' => 'yii\db\Connection',
    'driverName' => 'sybase',
    'schemaMap' => [
        'sybase' => \websightnl\yii2\sybase\Schema::className(),
    ],
//    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=192.168.0.40;port=5000;db=sgt;uid=xedrux;pwd=xedrux;AUTOCOMMIT=TRUE;',
    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=192.168.0.40;port=5000;db=sgt;uid=xedrux;pwd=xedrux;',
    'username' => 'xedrux',
    'password' => 'xedrux',
    'charset' => 'latin1',
    'attributes' => [
//        PDO::ATTR_PERSISTENT => TRUE,
//        PDO::ATTR_AUTOCOMMIT => FALSE
        PDO::ATTR_TIMEOUT => 1000
    ]
];

