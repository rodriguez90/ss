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
use yii\helpers\VarDumper;

class RbacController extends Controller
{
    const user_perm = [
            "admin_mod" => "Acceso al modulo administrción",
            "user_create" => "Crear Usuario",
            "user_update" => "Actualizar Usuarios",
            "user_delete" => "Eliminar Usuarios",
            "user_list" => "Listar Usuarios",
            "user_view" => "Ver Usuarios"
    ];

    const warehouse_perm = [
        "warehouse_create"=>"Crear Depósito",
        "warehouse_update"=>"Actualizar Depósito",
        "warehouse_delete" => "Eliminar Depósito",
        "warehouse_list"=>"Listar Depósito",
        "warehouse_view"=>"Detalle Depósito"
    ];

    const calendar_perm = [
        "calendar_create"=>"Crear calendario",
        "calendar_update"=>"Actualizar calendario",
        "calendar_delete"=>"Eliminar calendario",
        "calendar_list"=>"Listar calendario",
        "calendar_view"=>"Detalle de calendario"
    ];
    const process_perm = [
        "process_create"=>"Crear recepción",
        "process_update"=>"Actualizar recepción",
        "process_delete"=>"",
        "process_list"=>"",
        "process_view"=>""
    ];
    const agency_perm = ["agency_create"=>"",
        "agency_update"=>"",
        "agency_delete"=>"",
        "agency_list"=>"",
        "agency_view"=>""
    ];
    const ticket_perm = [
        "ticket_create"=>"",
        "ticket_update"=>"",
        "ticket_delete"=>"",
        "ticket_list"=>"",
        "ticket_view"=>""
    ];
    const transcompany_perm = [
        "trans_company_create"=>"",
        "trans_company_update"=>"",
        "trans_company_delete"=>"",
        "trans_company_list"=>"",
        "trans_company_view"=>""
    ];
    const container_perm = [
        "container_create"=>"",
        "container_update"=>"",
        "container_delete"=>"",
        "container_list"=>"",
        "container_view"=>""
    ];
    const ciatrans_perm = [
        "cia_trans_create"=>"",
        "cia_trans_update"=>"",
        "cia_trans_delete"=>"",
        "cia_trans_list"=>"",
        "cia_trans_view"=>""
    ];

    public function actionInit()
    {
        $msg = "!Error :";
        $ok = true;
        try {

            if ($ok) {
                if (!$this->actionCreateDefaulRoles()) {
                    $ok = false;
                    $msg = " No se crearon los roles por defecto. \n";
                }
            }

            if ($ok) {
                if (!$this->actionCreateDefaultPermisssion()) {
                    $ok = false;
                    $msg = " No se crearon los permisos por defecto. \n";
                }
            }

            if (!$this->actionCreateAdminUser()) {
                $ok = false;
                $msg = " No se pudo añadir el usuario administrador. \n";
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

    public function actionCreateAdminUser()
    {
        $msg = "Init successfully \n";
        $ok = true;
        $auth = Yii::$app->authManager;
        $transaction  = Yii::$app->getDb()->beginTransaction();

        try{

            $adminUser = new AdmUser();
            $adminUser->username = 'root';
            $adminUser->password = Yii::$app->security->generatePasswordHash("a");
            $adminUser->auth_key = $adminUser->password;
            $adminUser->password_reset_token = $adminUser->password;
            $adminUser->email = 'root2@gmail.com';
            $adminUser->nombre = 'root';
            $adminUser->apellidos = 'root';
            $adminUser->status = 1;
//            $adminUser->created_at = time();
//            $adminUser->updated_at = time();
            $adminUser->cedula = "1111111111";

            if (AdmUser::findOne(['username' => $adminUser->username]) == null)
            {
                if ($adminUser->save())
                {
                    echo "User created \n";

                    echo "Generating Access from admin role \n";
                }
                else
                {
                    $ok = false;
                    $msg = 'Error generating admin user.';
                }

            }

            if ($ok)
            {
                $permissions = array_merge(RbacController::user_perm,
                    RbacController::warehouse_perm,
                    RbacController::calendar_perm,
                    RbacController::process_perm,
                    RbacController::agency_perm,
                    RbacController::ticket_perm,
                    RbacController::transcompany_perm,
                    RbacController::container_perm,
                    RbacController::ciatrans_perm
                );

                $adminRol = $auth->getRole(AuthItem::ROLE_ADMIN);
                if($adminRol == null)
                {
                    $adminRol = $auth->createRole(AuthItem::ROLE_ADMIN);
                    $adminRol->description = "Administrador del sistema";
                    if($auth->add($adminRol) == false)
                    {
                        $ok = false;
                        $msg = 'Error al generar el rol administrador.';
                    }
                }

                if ($ok) {
                    foreach ($permissions as $name => $desc)
                    {
                        $pemission = $auth->getPermission($name);
                        if($pemission == null)
                        {
                            $pemission = $auth->createPermission($name);
                            $pemission->description = $desc;
                            if($auth->add($pemission) == false)
                            {
                                $ok = false;
                                $msg = 'Error al generar el permiso ' . $name;
                                break;
                            }
                        }

                        if ($ok)
                        {
                            if (!$auth->hasChild($adminRol, $pemission) && $auth->addChild($adminRol, $pemission) == false) {
                                $ok = false;
                                $msg = $msg . " No se pudo asignar el pemiso( " . $pemission->name . " al rol " . $adminRol->name . " )";
                            }
                        }
                    }

                }

                if ($adminUser->getId() != null && !$auth->checkAccess($adminUser->getId(), $adminRol->name)) {
                    $ok = $ok && $auth->assign($adminRol, $adminUser->getId());
                } else {
                    $ok = false;
                    $msg = $msg . " No se pudo asignar el rol (" . $adminRol->name . " ) al usuario ( " . $adminUser->username . " )";
                }
            }
        } catch (\Exception $ex) {
            $ok = false;
            $msg = $ex->getMessage() . "\n";
        }

        if ($ok) $transaction->commit();
        else $transaction->rollBack();

        echo $msg;
        return $ok;
    }

    public function actionCreateDefaulRoles()
    {
        $auth = Yii::$app->authManager;

        foreach (AuthItem::DEFAULT_ROLES as $name) {
            $role = $auth->createRole($name);
            if ($auth->getRole($role->name) === null) {
                if (!$auth->add($role)) {
                    return false;
                }
            }
        }

        echo 'Successfully generated default roles \n';

        return true;
    }

    public function actionCreateDefaultPermisssion()
    {

        $auth = Yii::$app->authManager;
        $ok= true;

        $permissions = array_merge(RbacController::user_perm,
            RbacController::warehouse_perm,
            RbacController::calendar_perm,
            RbacController::process_perm,
            RbacController::agency_perm,
            RbacController::ticket_perm,
            RbacController::transcompany_perm,
            RbacController::container_perm,
            RbacController::ciatrans_perm
        );

        $transaction  = Yii::$app->getDb()->beginTransaction();
        try {
            foreach ($permissions as $name => $desc)
            {
                if($auth->getPermission($name) == null)
                {
                    $permission = $auth->createPermission($name);
                    $permission->description = $desc;
                    $ok = $auth->add($permission);
                    if($ok == false)
                    {
                       echo 'Error when generating permission ' . $name;
                       break;
                    }
                    else
                    {
                        echo 'Permission ' . $name . ' generated \n';
                    }
                }
            }
        }
        catch (\Exception $ex)
        {
            $ok = false;
            echo  $ex->getMessage();
        }

        if($ok)
        {
            $transaction->commit();
            echo "Successfully generated permissions";
        }
        else $transaction->rollBack();

        return $ok;
    }

}