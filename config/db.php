<?php
//MS SQL Server (mediante sqlsrv driver): sqlsrv:Server=localhost;Database=mydatabase
//MS SQL Server (mediante dblib driver): dblib:host=localhost;dbname=mydatabase
//MS SQL Server (mediante mssql driver): mssql:host=localhost;dbname=mydatabase

$host="190.63.174.169";
$port = "7100";
$user = "xedrux";
$password = "xedrux";

//$conn = odbc_connect("sgt_xedrux",$user,$password);
//
//if (!$cid){
//    exit("<strong>Ya ocurrido un error tratando de conectarse con el origen de datos.</strong>");
//}
//else {
//    var_dump("Connecting.");die;
//}


//
//return [
//    'class' => 'yii\db\Connection',
//    'dsn' => 'odbc:dbname=190.63.174.169:7100/sgt',
//    'username' => 'xedrux',
//    'password' => 'xedrux',
//    'charset' => 'utf8',
//];

//return [
//   'class' => 'yii\db\Connection',
//   'schemaMap' => [
//        'sybase' => \websightnl\yii2\sybase\Schema::className(),
//   ],
//    'dsn' => 'odbc:sgt_xedrux',
//   'username' => $user,
//   'password' => $password,
//];


 return [
     'class' => 'yii\db\Connection',
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
