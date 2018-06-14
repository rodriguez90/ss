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
    public function actionInit22()
    {
        $msg = "!Error :";
        $ok = true;
        try {

            if (!$this->CreateAdminUser()) {
                $ok = false;
                $msg = " No se pudo añadir el usuario administrador. ";
            }

            if ($ok) {
                if (!$this->actionCreateDefaulRoles()) {
                    $ok = false;
                    $msg = " No se crearon los roles por defecto. ";
                }
            }

            if ($ok) {
                if ($this->actionCreateDefaultPermisssion()) {
                    $ok = false;
                    $msg = " No se crearon los permisos por defecto. ";
                }
            }

        } catch (\Exception $ex) {
            $ok = false;
            $msg = $msg . " ex: " . $ex->getMessage();
        }

        if ($ok) {
            echo "Migración OK...";
        } else
            echo $msg;
    }


    public function CreateAdminUser()
    {
        $auth = Yii::$app->authManager;

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

        if (AdmUser::findOne(['username' => $adminUser->username]) == null && $adminUser->save()) {
            return true;
        }

        return false;
    }


    public function actionCreateDefaulRoles()
    {
        $auth = Yii::$app->authManager;
        foreach (AuthItem::DEFAULT_ROLES as $role) {
            $rolModel = $auth->createRole($role);
            if ($auth->getRole($rolModel->name) === null) {
                if (!$auth->add($rolModel)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function actionInit()
    {
        $msg = "!Error :";
        $ok = true;
        try{
            $auth = Yii::$app->authManager;

            $admin_perm = [];

            $user_perm = ["admin_mod" => "Acceso al modulo administrción","user_create" => "Crear Usuario", "user_update" => "Actualizar Usuarios", "user_delete" => "Eliminar Usuarios", "user_list" => "Listar Usuarios", "user_view" => "Ver Usuarios"];
            $warehouse_perm = ["warehouse_create"=>"Crear Depósito", "warehouse_update"=>"Actualizar Depósito", "warehouse_delete" => "Eliminar Depósito", "warehouse_list"=>"Listar Depósito", "warehouse_view"=>"Detalle Depósito"];
            $calendar_perm = ["calendar_create"=>"Crear calendario", "calendar_update"=>"Actualizar calendario", "calendar_delete"=>"Eliminar calendario", "calendar_list"=>"Listar calendario", "calendar_view"=>"Detalle de calendario"];
            $reception_perm = ["reception_create"=>"Crear recepción", "reception_update"=>"Actualizar recepción", "reception_delete"=>"", "reception_list"=>"", "reception_view"=>""];
            $agency_perm = ["agency_create"=>"", "agency_update"=>"", "agency_delete"=>"", "agency_list"=>"", "agency_view"=>""];
            $ticket_perm = ["ticket_create"=>"", "ticket_update"=>"", "ticket_delete"=>"", "ticket_list"=>"", "ticket_view"=>""];
            $transcompany_perm = ["trans_company_create"=>"", "trans_company_update"=>"", "trans_company_delete"=>"", "trans_company_list"=>"", "trans_company_view"=>""];
            $container_perm = ["container_create"=>"", "container_update"=>"", "container_delete"=>"", "container_list"=>"", "container_view"=>""];
            $ciatrans_perm = ["cia_trans_create"=>"", "cia_trans_update"=>"", "cia_trans_delete"=>"", "cia_trans_list"=>"", "cia_trans_view"=>""];

            $admin_perm [0] = $user_perm;
            $admin_perm [1] = $warehouse_perm;
            $admin_perm [2] = $calendar_perm;
            $admin_perm [3] = $reception_perm;
            $admin_perm [4] = $agency_perm;
            $admin_perm [5] = $ticket_perm;
            $admin_perm [6] = $transcompany_perm;
            $admin_perm [7] = $container_perm;
            $admin_perm [8] = $ciatrans_perm;

            echo "1";

            //crealo independiente y asignar rolesy perms
            $adminUser = new AdmUser();
            $adminUser->username = 'root2';
            $adminUser->password = Yii::$app->security->generatePasswordHash("a");
            $adminUser->email = 'root2@gmail.com';
            $adminUser->nombre = 'root2';
            $adminUser->apellidos = 'root';
            $adminUser->status = 1;
            $adminUser->created_at = time();
            $adminUser->updated_at = time();
            $adminUser->cedula = "2012345678";

            if (AdmUser::findOne(['username' => $adminUser->username]) == null && $adminUser->save()) {
                $ok = true;
                echo "2";
            } else {
                $ok = false;
                $msg =  $msg . " No se pudo añadir el usuario administrador. ";
                echo "3";
            }

            echo "4";
            if ($ok) {
                echo "4.5";
                $adminRol = $auth->createRole(AuthItem::ROLE_ADMIN);
                $adminRol->description = "Administrador del sistema";
                if ($auth->getRole($adminRol->name) == null) {
                    $ok = $ok && $auth->add($adminRol);
                    if ($ok) {
                        echo "5";
                        foreach ($admin_perm as $perms){
                             echo "6";
                            foreach ($perms as $key => $desc) {
                                $pemiso = $auth->createPermission($key);
                                $pemiso->description = $desc;
                                echo "6.5";
                                if ($auth->getPermission($pemiso->name) == null)
                                    $ok = $ok && $auth->add($pemiso);
                                if ($ok) {
                                    echo "7";
                                    if (!$auth->hasChild($adminRol, $pemiso)) {
                                        $ok = $ok && $auth->addChild($adminRol, $pemiso);
                                        if (!$ok) {
                                            echo "8";
                                            $msg = $msg . " No se pudo asignar el pemiso( " . $pemiso->name . " al rol " . $adminRol->name . " )";
                                        }
                                    }
                                } else {

                                    $msg =  $msg . " No se pudo añadir el permiso ( " . $pemiso->name . " )";
                                }
                            }
                        }

                    } else {
                        $msg =   $msg . " No se pudo añadir el rol ( " . $adminRol->name . " )";
                    }

                    if ($adminUser->getId() != null && !$auth->checkAccess($adminUser->getId(), $adminRol->name)) {
                        $ok = $ok && $auth->assign($adminRol, $adminUser->getId());
                    } else {
                        $ok = false;
                        $msg = $msg . " No se pudo asignar el rol (" . $adminRol->name . " ) al usuario ( " . $adminUser->username . " )";
                    }
                }else{
                    $ok = false;
                    $msg = $msg . " Ya existe el rol ". $adminRol->name;
                }
            }


        } catch (\Exception $ex) {
            $ok = false;
            $msg = $msg . " ex: " . $ex->getMessage();
        }

        if ($ok) {
            echo "Migración OK...";
        } else
            echo $msg;

    }




    public function actionOn(){


        $auth = Yii::$app->authManager;
        $ok= true;

        $user_perm = ["admin_mod" => "Acceso al modulo administrción","user_create" => "Crear Usuario", "user_update" => "Actualizar Usuarios", "user_delete" => "Eliminar Usuarios", "user_list" => "Listar Usuarios", "user_view" => "Ver Usuarios"];
        $warehouse_perm = ["warehouse_create"=>"Crear Depósito", "warehouse_update"=>"Actualizar Depósito", "warehouse_delete" => "Eliminar Depósito", "warehouse_list"=>"Listar Depósito", "warehouse_view"=>"Detalle Depósito"];
        $calendar_perm = ["calendar_create"=>"Crear calendario", "calendar_update"=>"Actualizar calendario", "calendar_delete"=>"Eliminar calendario", "calendar_list"=>"Listar calendario", "calendar_view"=>"Detalle de calendario"];
        $reception_perm = ["reception_create"=>"Crear recepción", "reception_update"=>"Actualizar recepción", "reception_delete"=>"", "reception_list"=>"", "reception_view"=>""];
        $agency_perm = ["agency_create"=>"", "agency_update"=>"", "agency_delete"=>"", "agency_list"=>"", "agency_view"=>""];
        $ticket_perm = ["ticket_create"=>"", "ticket_update"=>"", "ticket_delete"=>"", "ticket_list"=>"", "ticket_view"=>""];
        $transcompany_perm = ["trans_company_create"=>"", "trans_company_update"=>"", "trans_company_delete"=>"", "trans_company_list"=>"", "trans_company_view"=>""];
        $container_perm = ["container_create"=>"", "container_update"=>"", "container_delete"=>"", "container_list"=>"", "container_view"=>""];
        $ciatrans_perm = ["cia_trans_create"=>"", "cia_trans_update"=>"", "cia_trans_delete"=>"", "cia_trans_list"=>"", "cia_trans_view"=>""];


        $admin_perm [0] = $user_perm;
        $admin_perm [1] = $warehouse_perm;
        $admin_perm [2] = $calendar_perm;
        $admin_perm [3] = $reception_perm;
        $admin_perm [4] = $agency_perm;
        $admin_perm [5] = $ticket_perm;
        $admin_perm [6] = $transcompany_perm;
        $admin_perm [7] = $container_perm;
        $admin_perm [8] = $ciatrans_perm;


        $adminRol = $auth->createRole("Administracion");

        foreach ($admin_perm as $perms){
            foreach ($perms as $key => $desc) {

                if (!$auth->hasChild($adminRol,$auth->getPermission($key))) {
                    $ok = $ok && $auth->addChild($adminRol, $auth->getPermission($key));

                }

            }
        }


        /*

        foreach ($warehouse_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($calendar_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($reception_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($agency_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($ticket_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($transcompany_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }
        foreach ($container_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }

        foreach ($ciatrans_perm as $key => $desc) {
            $pemiso = $auth->createPermission($key);
            $pemiso->description = $desc;
            echo "6.5";
            if ($auth->getPermission($pemiso->name) == null)
                $ok = $ok && $auth->add($pemiso);
        }


        */

        if($ok)
            echo "OK....";
        else
            "Error";
    }

}