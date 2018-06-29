<?php
//MS SQL Server (mediante sqlsrv driver): sqlsrv:Server=localhost;Database=mydatabase
//MS SQL Server (mediante dblib driver): dblib:host=localhost;dbname=mydatabase
//MS SQL Server (mediante mssql driver): mssql:host=localhost;dbname=mydatabase

$host="190.63.174.169";
$port = "7100";
$user = "xedrux";
$password = "xedrux";

//return [
//   'class' => 'yii\db\Connection',
//    'driverName' => 'sybase',
//   'schemaMap' => [
//        'sybase' => \websightnl\yii2\sybase\Schema::className(),
//   ],
//    'dsn' => 'odbc:sgt_xedrux',
////    'dsn' => 'odbc:xedrux',
//   'username' => $user,
//   'password' => $password,
//];

//return [
//    'class' => 'yii\db\Connection',
//    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
//    //'dsn' => 'pgsql:host=127.0.0.1;port=5433;dbname=bolsa_rrhh',
//    'driverName' => 'sybase',
//    'schemaMap' => [
//        'sybase' => \websightnl\yii2\sybase\Schema::className(),
//    ],
//    //'dsn' => 'odbc:host=190.63.174.169;port=7100;dbname=sgt',
//    //'dsn' => 'odbc:DRIVER={Adaptive Server Anywhere 7.0};SERVER=190.63.174.169;PORT=7100;DATABASE=sgt;UID=xedrux;PWD=xedrux',
//    //'dsn' => 'odbc:Driver=Adaptive Server Anywhere 7.0;ENG=190.63.174.169.sgt;UID=xedrux;PWD=xedrux;DBN=sgt;LINKS=TCPIP(HOST=190.63.174.169:7100);',
//    //'dsn' => 'odbc:Driver={Adaptive Server Enterprise};app=sgt;server=190.63.174.169;port=7100;db=sgt;uid=xedrux;pwd=xedrux;',
//    'dsn' => 'odbc:Driver={Adaptive Server Enterprise};NA=190.63.174.169,7100;Uid=xedrux;Pwd=xedrux;',
////    'dsn' => 'odbc:Driver={SYBASE ASE ODBC Driver};NA=190.63.174.169,7100;Uid=xedrux;Pwd=xedrux;',
//    //'dsn' => 'odbc:Driver={SQL Anywhere 12};Server=189902;CommLinks=tcpip(Host=1.2.3.4);',
//    //'dsn' => 'odbc:host=190.63.174.169;port=7100;dbname=sgt',
//    'username' => 'xedrux',
//    'password' => 'xedrux',
//    //'charset' => 'utf8',
//
//    // Schema cache options (for production environment)
//    //'enableSchemaCache' => true,
//    //'schemaCacheDuration' => 60,
//    //'schemaCache' => 'cache',
//];

 return [
     'class' => 'yii\db\Connection',
//	 'dsn'=>'odbc:Server=PEDRO-PC\SQLEXPRESS;Database=sgt',
	 'dsn'=>'sqlsrv:Server=PEDRO-PC\SQLEXPRESS;Database=sgt',
 //	'dsn'=>'sybase:Server=190.63.174.169:7100;Database=sgt',
 //    sqlsrv:Server=WIN-FV2H1LSOO63\SQLEXPRESS;Database=sgt
   //  'dsn'=>'sqlsrv:Server=DESKTOP-JH5RE76\SQLEXPRESS;Database=sgt',
 //    'username' => $user,
     'username' => '',
 //    'password' => $password, //Root*2018
     'password' => '', //Root*2018
     'charset' => 'utf8',

     // Schema cache options (for production environment)
     //'enableSchemaCache' => true,
     //'schemaCacheDuration' => 60,
     //'schemaCache' => 'cache',
 ];
