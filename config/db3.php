<?php
return [
    'class' => 'yii\db\Connection',
    'driverName' => 'sybase',
    'schemaMap' => [
        'sybase' => \websightnl\yii2\sybase\Schema::className(),
    ],
    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=192.168.0.40;port=5000;db=disv;uid=xedrux;pwd=xedrux;',
    'username' => 'xedrux',
    'password' => 'xedrux',
    'charset' => 'latin1',
];