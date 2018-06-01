<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 31/05/2018
 * Time: 21:42
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\modules\administracion\models\AdmUser;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
//
//        $adminUser = new AdmUser();
//        $adminUser->username = 'root';
//        $adminUser->auth_key = 'root';
//        $adminUser->password = 'root';
//        $adminUser->email = 'root@gmail.com';
//        $adminUser->nombre = 'root';
//        $adminUser->apellidos = 'root';
//        $adminUser->creado_por = 'migration';
//        $adminUser->status = 1;
//        $adminUser->created_at = getdate();
//        $adminUser->updated_at = getdate();
//
//        $adminUser->save();

        // add "createPost" permission
        $adminMod = $auth->createPermission('Admin_mod');
        $adminMod->description = 'Administrador del Sistema';
        $auth->add($adminMod);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');

        $auth->add($admin);
//        $auth->addChild($admin, $adminUser->getId());
    }
}