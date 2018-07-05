<?php
//MS SQL Server (mediante sqlsrv driver): sqlsrv:Server=localhost;Database=mydatabase
//MS SQL Server (mediante dblib driver): dblib:host=localhost;dbname=mydatabase
//MS SQL Server (mediante mssql driver): mssql:host=localhost;dbname=mydatabase
/*
$host="190.63.174.169";
$port = "7100";
$user = "xedrux";
$password = "xedrux";

*/

// Sybase Data Base Connection !!! NO WORK - Testing

//return [
//   'class' => 'yii\db\Connection',
//    'driverName' => 'sybase',
//   'schemaMap' => [
//        'sybase' => \websightnl\yii2\sybase\Schema::className(),
//   ],
////    'dsn' => 'odbc:sgt_xedrux',
//    'dsn' => 'odbc:xedrux_64',
//   'username' => $user,
//   'password' => $password,
//];
//
//return [
//    'class' => 'yii\db\Connection',
//    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
//    //'dsn' => 'pgsql:host=127.0.0.1;port=5433;dbname=bolsa_rrhh',
//    'driverName' => 'sybase',
//    'schemaMap' => [
//        'sybase' => \websightnl\yii2\sybase\Schema::className(),
//    ],
//    //'dsn' => 'odbc:Driver={SYBASE ASE ODBC Driver};NA=190.63.174.169,7100;Uid=xedrux;Pwd=xedrux;',
//    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=190.63.174.169;port=7100;db=sgt;uid=xedrux;pwd=xedrux;',
//    'username' => 'xedrux',
//    'password' => 'xedrux',
//    //'charset' => 'utf8',
//
//    // Schema cache options (for production environment)
//    //'enableSchemaCache' => true,
//    //'schemaCacheDuration' => 60,
//    //'schemaCache' => 'cache',
//];



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
    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=190.63.174.169;port=7100;db=sgt;uid=xedrux;pwd=xedrux;AUTOCOMMIT=TRUE;',
//    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=SGT;server=190.63.174.169;port=7100;db=sgt;uid=xedrux;pwd=xedrux;',
    'username' => 'xedrux',
    'password' => 'xedrux',
    'charset' => 'latin1',
//    'attributes' => [
////        PDO::ATTR_PERSISTENT => TRUE,
////        PDO::ATTR_AUTOCOMMIT => FALSE
//        PDO::ATTR_TIMEOUT => 1000
//    ]

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

// Localhost Sql Serve Data Base Connection
//
// return [
//     'class' => 'yii\db\Connection',
//	 'dsn'=>'sqlsrv:Server=PEDRO-PC\SQLEXPRESS;Database=sgt',
// //    sqlsrv:Server=WIN-FV2H1LSOO63\SQLEXPRESS;Database=sgt
////     'dsn'=>'sqlsrv:Server=DESKTOP-JH5RE76\SQLEXPRESS;Database=sgt',
//     'username' => '',
//     'password' => '', //Root*2018
//     'charset' => 'utf8',
//
//     // Schema cache options (for production environment)
//     //'enableSchemaCache' => true,
//     //'schemaCacheDuration' => 60,
//     //'schemaCache' => 'cache',
// ];
