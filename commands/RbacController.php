<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 31/05/2018
 * Time: 21:42
 */

namespace app\commands;

use app\modules\administracion\models\AuthItem;
use Yii;
use yii\console\Controller;
use app\modules\administracion\models\AdmUser;

class RbacController extends Controller
{
    public function actionInit()
    {
        $msg = 'Error: ';
        $ok = true;
        try{
            Yii::$app->authManager;
            $result = $this->actionCreateAdminUser();

            if(isset($result['msg']))
            {
                $ok= false;
                $msg = $result['msg'];
            }

            if(ok)
            {
                $ok = $this->actionCreateDefaulRoles() === null;
            }

            if(!$ok)
                $msg = $msg . 'Al crear los roles';

            if($ok)
            {
                $ok = $this->actionCreateDefaultPermisssion() === null;
            }

            if(!$ok)
                $msg = $msg . 'Al crear los permisos';

        }catch (\Exception $ex){
            $ok = false;
            $msg = $msg. "ex: ". $ex;
        }

       if($ok){
           echo "Migración OK...";
       }else
          echo $msg;
    }

    public function actionCreateAdminUser()
    {
        $auth = Yii::$app->authManager;
        //$auth->removeAll();
        $ok = true;
        $result = [];
        $msg = "Error, ";

        $adminUser = new AdmUser();
        $adminUser->username = 'root';
        $adminUser->password = Yii::$app->security->generatePasswordHash("a");
        $adminUser->email = 'root2@gmail.com';
        $adminUser->nombre = 'root';
        $adminUser->apellidos = 'root';
        $adminUser->status = 1;
        $adminUser->created_at = time();
        $adminUser->updated_at = time();
        $adminUser->cedula = "2012345678";

        if (!AdmUser::findOne(['username' => $adminUser->username]) == null && $adminUser->save())
        {
            $adminUser = null;
            $result['msg'] = $msg."No se pudo añadir el usuario.";
        }
        $result['user'] = $adminUser;
        return $adminUser;
    }

    public function actionCreateDefaulRoles()
    {
        $auth = Yii::$app->authManager;

        foreach (AuthItem::DEFAULT_ROLES as $role)
        {
            $rolModel = $auth->createRole($role);
            if($auth->getRole($rolModel->name) === null){
                if(!$auth->add($rolModel))
                {
                    return false;
                }
            }
        }

        return true;
    }

    public function actionCreateDefaultPermisssion()
    {
        // add "createPost" permission
        $auth = Yii::$app->authManager;

        // los permisos son generados x los tablas o modelos que tenemos en el sistema
        /*
         * Ejemplo
         * Modelo Reception tendriamos:
         * reception_create
         * reception_update
         * reception_delete
         * reception_list
         * reception_view
         *
         * estos son los permisos basicos que se pueden autogenerar por un modelo
         */

        // TODO: VER ESTO
//        $adminMod = $auth->createPermission('Admin_mod2');
//        $adminMod->description = 'Acceso al modulo de administración';
//        if($auth->getPermission($adminMod->name)==null)
//            $ok = $ok && $auth->add($adminMod);
//        else
//            $msg = $msg." No se pudo añadir el permiso ( ".$adminMod->name . " )";
//
//        // add "admin" role and give this role the "updatePost" permission
//        // as well as the permissions of the "author" role
//        $adminRol = $auth->createRole(AuthItem::ROLE_ADMIN);
//        $adminRol->description = "Administrador del sistema";
//        if($auth->getRole($adminRol->name)==null){
//            $ok = $ok && $auth->add($adminRol);
//        }
//        else
//            $msg = $msg." No se pudo añadir el rol ( ".$adminRol->name . " )";
//
//
//        if(!$auth->hasChild($adminRol,$adminMod)){
//            $ok = $ok && $auth->addChild($adminRol,$adminMod);
//        }
//        else
//            $msg = $msg." No se pudo asignar el permiso ( ".$adminMod->name . " al rol ". $adminRol->name ." )";
//
//        if($adminUser->getId() != null && !$auth->checkAccess($adminUser->getId(),$adminRol->name)){
//            $ok = $ok &&  $auth->assign($adminRol,$adminUser->getId());
//        }
//        else
//            $msg = $msg." No se pudo asignar el rol (".$adminRol->name." ) al usuario ( ".$adminUser->username ." )";
    }
}