<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 01/07/2018
 * Time: 1:46
 */

return [
    'class' => 'yii\db\Connection',
    'dsn'=>'sqlsrv:Server=192.168.0.169,1433;Database=atack',
    //'dsn'=>'sqlsrv:Server=190.63.174.169,7200;Database=atack',
    'username' => 'xedrux',
    'password' => 'xedrux', //Root*2018
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];