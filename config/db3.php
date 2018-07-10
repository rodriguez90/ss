<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 03/07/2018
 * Time: 20:49
 */

// Sybase Data Base Connection !!! WORK
return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    //'dsn' => 'pgsql:host=127.0.0.1;port=5433;dbname=bolsa_rrhh',
    'driverName' => 'sybase',
    'schemaMap' => [
        'sybase' => \websightnl\yii2\sybase\Schema::className(),
    ],
    //'dsn' => 'odbc:Driver={SYBASE ASE ODBC Driver};NA=190.63.174.169,7100;Uid=xedrux;Pwd=xedrux;',
    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=190.63.174.169;port=7100;db=disv;uid=xedrux;pwd=xedrux;',
//    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=190.63.174.169;port=7100;db=sgt;uid=xedrux;pwd=xedrux;',
    'username' => 'xedrux',
    'password' => 'xedrux',
    'charset' => 'latin1',
    'attributes' => [
//        PDO::ATTR_PERSISTENT => TRUE,
//        PDO::ATTR_AUTOCOMMIT => FALSE
        PDO::ATTR_TIMEOUT => 1000
    ]
];