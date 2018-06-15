<?php
//MS SQL Server (mediante sqlsrv driver): sqlsrv:Server=localhost;Database=mydatabase
//MS SQL Server (mediante dblib driver): dblib:host=localhost;dbname=mydatabase
//MS SQL Server (mediante mssql driver): mssql:host=localhost;dbname=mydatabase

return [
    'class' => 'yii\db\Connection',
	'dsn'=>'sqlsrv:Server=PEDRO-PC\SQLEXPRESS;Database=sgt',
//    'dsn'=>'sqlsrv:Server=DESKTOP-JH5RE76\SQLEXPRESS;Database=sgt',
    'username' => '',
    'password' => '', //Root*2018
    'charset' => 'utf8',


    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
