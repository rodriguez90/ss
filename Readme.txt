Como desplegar la aplicación

1- Instalar Sql Sever, recomendamos una version superior o igual a 2008
2- Instalar el xampp-win32-7.2.4-0-VC15
3- Descargar los driver de sql server para php
    php_sqlsrv_72_ts_x86
    php_pdo_sqlsrv_72_ts_x86
4- Configurar los driver anteriormente descargados como extension de php.
    - Ir al C:\xampp\php\php.ini y copiar lo siguiente:
      extension=php_sqlsrv_72_ts_x86
      extension=php_pdo_sqlsrv_72_ts_x86
5- Copiar el projecto en: C:\xampp\htdocs\
6- Crear la base datos sgt
7- Correr el scritp sql que esta en la carpeta sql del proyecto
8- Configurar la conección de la base datos en la aplicación: C:\xampp\htdocs\sgt\config\db.php
