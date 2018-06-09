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


        try{

            $auth = Yii::$app->authManager;
            //$auth->removeAll();
            $ok = true;
            $msg = "Error, ";

            $adminUser = new AdmUser();
            $adminUser->username = 'root2';
            $adminUser->password = Yii::$app->security->generatePasswordHash("a");
            $adminUser->email = 'root2@gmail.com';
            $adminUser->nombre = 'root2';
            $adminUser->apellidos = 'root2';
            $adminUser->status = 1;
            $adminUser->created_at = time();
            $adminUser->updated_at = time();
            $adminUser->cedula = "2012345678";

            if (AdmUser::findOne(['username' => $adminUser->username]) == null && $adminUser->save()) {
                $ok = true;
            }
            else{
                $msg = $msg."No se pudo añadir el usuario.";
                $ok = false;
            }

            // add "createPost" permission
            $adminMod = $auth->createPermission('Admin_mod2');
            $adminMod->description = 'Acceso al modulo de administración';
            if($auth->getPermission($adminMod->name)==null)
                $ok = $ok && $auth->add($adminMod);
            else
                $msg = $msg." No se pudo añadir el permiso ( ".$adminMod->name . " )";

            // add "admin" role and give this role the "updatePost" permission
            // as well as the permissions of the "author" role
            $adminRol = $auth->createRole('administrador');
            $adminRol->description = "Administrador 2 del sistema";
            if($auth->getRole($adminRol->name)==null){
                $ok = $ok && $auth->add($adminRol);
            }
            else
                $msg = $msg." No se pudo añadir el rol ( ".$adminRol->name . " )";

            if(!$auth->hasChild($adminRol,$adminMod)){
                $ok = $ok && $auth->addChild($adminRol,$adminMod);
            }
            else
                $msg = $msg." No se pudo asignar el permiso ( ".$adminMod->name . " al rol ". $adminRol->name ." )";

            if($adminUser->getId() != null && !$auth->checkAccess($adminUser->getId(),$adminRol->name)){
                $ok = $ok &&  $auth->assign($adminRol,$adminUser->getId());
            }
            else
                $msg = $msg." No se pudo asignar el rol (".$adminRol->name." ) al usuario ( ".$adminUser->username ." )";



        }catch (\Exception $ex){
            $msg = $msg. "ex: ". $ex;
        }


       if($ok){
           echo "Migración OK...";
       }else
          echo $msg;

//
    }
}