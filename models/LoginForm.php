<?php

namespace app\models;

use app\modules\administracion\models\AdmUser;
use app\modules\administracion\models\AuthItem;
use app\modules\rd\models\Agency;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;
use app\modules\rd\models\UserWarehouse;
use app\modules\rd\models\Warehouse;
use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
//            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $customPassword = $this->makeTPGPassword($this->password);

        $response = $this->tpgLogin($this->username, $customPassword); // FIXME en produccion pasar el $customPassword
//        $response = $this->tpgLoginOffLine($this->username, $customPassword);

		$userData = $response['user'];

        if(!$response['success'])
        {
            $this->addError('error', 'Ah ocurrido un error al realizar la autenticación con TPG.');
            return false;
        }
        elseif ($userData == null)
        {
            $this->addError('error', 'Usuario o Contraseña Incorrecta.');// 1'. mb_convert_encoding ( $this->username, "UTF-8","ISO-8859-1" ));
            return false;
        }
        elseif ($userData !== null && $userData['estado'] !== "ACTIVO")
        {
            $this->addError('error', 'El usuario esta inactivo, consulte al administrador.');
            return false;
        }

        $newUser = AdmUser::findOne(['username'=>$this->username]); // find user in sgt

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $auth =  Yii::$app->authManager;
            $resultLogin = true;

            if($newUser == null) // user no exit in sgt
            {
                $newUser = new AdmUser();
                $newUser->username = $userData['user_id'];
                $newUser->nombre = $userData['nombre'];
                $newUser->apellidos = '';
                $newUser->cedula = $userData['ruc'];
                $newUser->email = $userData['email'];
                $newUser->status = $userData['estado'] == "ACTIVO" ? 1:0;
                $newUser->created_at = time();
                $newUser->updated_at = time();
                $newUser->creado_por = 'login';
                $newUser->setPassword($this->password);

                $new_rol = null;

                if ($newUser->save())
                {
                    $roleName = $userData['rol'];
                    $rol = AuthItem::MAP_TPG_ROLE_TO_SGT[$roleName];

                    $result = $this->registerUserEntity($newUser, $userData, $roleName);

                    if(!$result['success'])
                    {
                        $this->addError('error', $result['msg']);
                        $resultLogin = false;
                    }

                    if($resultLogin)
                    {
                        $new_rol = $auth->getRole($rol);

                        if($new_rol == null)
                        {
                            $msg = "Ah ocurrido un error al buscar el rol asigando al usuario.";
                            $this->addError('error', $msg);
                            $resultLogin = false;
                        }

                        if(!$auth->assign($new_rol, $newUser->id))
                        {
                            $msg = "Ah ocurrido un error al registar el rol del usuario.";
                            $this->addError('error', $msg);
                            $resultLogin = false;
                        }
                    }
                }
                else
                {

                    $msg = "Ah ocurrido un error al registrar el usuario.";
                    $this->addError('error', $msg);
                    $resultLogin = false;
                }
            }
            else // the user exist in sgt
            {
                $currentRolName = $newUser->getRole();
                $newRolName = AuthItem::MAP_TPG_ROLE_TO_SGT[$userData['rol']];

                $newUser->nombre = $userData['nombre'];
                $newUser->apellidos = '';
                $newUser->cedula = $userData['ruc'];
                $newUser->email = $userData['email'];
                $newUser->status = $userData['estado'] == "ACTIVO" ? 1:0;
                $newUser->created_at = time();
                $newUser->updated_at = time();
                $newUser->creado_por = 'login';
                $newUser->setPassword($this->password);

                if(!$newUser->save())
                {
                    $this->addError('error', 'Ah ocurrido un error al actualziar los datos del usuario.');
                    $resultLogin = false;
                }

                if($resultLogin && $currentRolName != $newRolName)
                {
                    if($currentRolName != null)
                    {
                        $currentRol = $auth->getRole($currentRolName);

                        if(!$auth->revoke($currentRol, $newUser->id))
                        {
                            $msg = "Ah ocurrido un error al revocar el rol del usuario.";
                            $this->addError('error', $msg);
                            $resultLogin = false;
                        }
                    }

                    $newRol = $auth->getRole($newRolName);

                    if($newRol == null)
                    {
                        $msg = "Ah ocurrido un error al buscar el rol asigando al usuario.";
                        $this->addError('error', $msg);
                        $resultLogin = false;
                    }

                    if($resultLogin && !$auth->assign($newRol, $newUser->id))
                    {
                        $msg = "Ah ocurrido un error al acutalizar el rol del usuario.";
                        $this->addError('error', $msg);
                        $resultLogin = false;
                    }
                }

                if($resultLogin)
                {
                    $result = $this->unregisterUserEntity($newUser);

                    if(!$result['success'])
                    {
                        $this->addError('error', $result['msg']);
                        return false;
                    }
                }

                if($resultLogin)
                {
                    $result = $this->registerUserEntity($newUser, $userData, $userData['rol']);

                    if(!$result['success'])
                    {
                        $this->addError('error', $result['msg']);
                        return false;
                    }
                }
            }
            if($resultLogin)
                $transaction->commit();
            else
                $transaction->rollBack();
        }
        catch (\PDOException $e)
        {
            if($e->getCode() !== '01000')
            {
                $this->addError('error', "Ah ocurrido un error al relizar la autenticación.");
                $transaction->rollBack();
                return false;
            }
        }

        return Yii::$app->user->login($newUser, $this->rememberMe == 'on' ? 1800 : 0);
    }

    public function loginOffLine()
    {
        $userData=[];
        $userData['user'] = [
            'user_id'=> $this->username,
            'nombre'=> $this->username,
            'ruc' => '8769543201',
            'email' => 'test@co.cu',
            'ruc_empresa'=> '1111111111111',
            'nombre_empresa'=>'test s.a',
            'rol'=>'DEPOSITO',
            'estado'=>'ACTIVO',
        ];


        $newUser = AdmUser::findOne(['username'=>$this->username]); // find user in sgt

        if($newUser == null)
        {
            $msg = "El usuario no existe.";
            $this->addError('error', $msg);
            return false;
        }
        elseif ($newUser->status !== 1)
        {
            $msg = "Esta cuenta no esta activa.";
            $this->addError('error', $msg);
            return false;
        }


        return Yii::$app->user->login($newUser, $this->rememberMe == 'on' ? 1800 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = AdmUser::findByUsername($this->username);
        }

        return $this->_user;
    }

    protected function tpgLogin($user, $password)
    {
        $response = array();
        $response['success'] = true;
        $response['user'] = null;
        $response['msg'] = '';
        $response['msg_dev'] = '';

        try
        {
            $sql = "exec disv..pa_login_disv '" . $user . "','" . $password . "'";

            //int(42000) string(18) "Database Exception" string(369) "SQLSTATE[42000]: Syntax error or access violation: 257 [Sybase][ODBC Driver][Adaptive Server Enterprise]Implicit conversion from datatype 'TEXT' to 'VARCHAR' is not allowed. Use the CONVERT function to run this query. (SQLExecute[257] at ext\pdo_odbc\odbc_stmt.c:260) The SQL being executed was: exec disv..pa_login_disv 'developer','FEA803DA71FE37CD278A4189ECA4752E'"
//            $sql = "exec disv..pa_login_disv :user,:password";
//            $result = Yii::$app->db3->createCommand($sql)
//                ->bindValue(':user',$user)
//                ->bindValue(':password',$password)
//                ->queryAll();
            $result = Yii::$app->db3->createCommand($sql)
                                    ->queryAll();
            if(count($result) > 0)
            {
                // $result['nombre'] = utf8_decode($result['nombre']);
                // $result['nombre_empresa'] = utf8_decode($result['nombre_empresa']);
				// user_id,nombre,ruc,email,ruc_empresa,nombre_empresa,rol,estado

                $response['user'] = [
						'user_id'=> $result[0]['user_id'],
						'nombre'=> $result[0]['nombre'],
						'ruc' => $result[0]['ruc'],
						'email' => $result[0]['email'],
						'ruc_empresa'=> $result[0]['ruc_empresa'],
						'nombre_empresa'=>$result[0]['nombre_empresa'],
						'rol'=>$result[0]['rol'],
						'estado'=>$result[0]['estado'],
				];
            }
        }
        catch (Exception $ex)
        {

//            var_dump($ex->getCode());
//            var_dump($ex->getName());
//            var_dump($ex->getMessage()); die;

            $response['success'] = false;
            $response['msg'] = 'Ah occurrido un error al realizar el login hacia TPG.';
            $response['msg_dev'] = $ex->getMessage();
        }

        return $response;
    }

    protected function tpgLoginOffLine($user, $password)
    {
        $response = array();
        $response['success'] = true;
        $response['user'] = null;
        $response['msg'] = '';
        $response['msg_dev'] = '';
        $response['user'] = [
            'user_id'=> $this->username,
            'nombre'=> $this->username,
            'ruc' => '8769543201',
            'email' => 'agency@test.co',
            'ruc_empresa'=> '1291750490001',
            'nombre_empresa'=>'trans prueba',
//            'rol'=>'ADMINISTRADOR_DEPOSITO',
//            'rol'=>'DEPOSITO',
//            'rol'=>'CIA_TRANSPORTE',
//            'rol'=>'IMPORTADOR_EXPORTADOR',
//            'rol'=>'IMPORTADOR_EXPORTADOR_ESPECIAL',
            'rol'=>'ADMINISTRADOR',
            'estado'=>'ACTIVO',
        ];

        return $response;
    }

    protected function makeTPGPassword($password)
    {
        $p = md5($password);
        $clavefin = $this->amaguemd5($p);
        $upperClave = strtoupper($clavefin);
        return $upperClave;
    }

    protected  function amaguemd5($p) {

        // altera el md5 antes de grabarlo
        // Assume que $p tiene 32 chars de largo
        $q = $p{20} . $p{15} . $p{5} . $p{17} . $p{23} . $p{0} . $p{28} . $p{4} . $p{18} . $p{11} . $p{6} . $p{13} . $p{14} . $p{9} . $p{31} . $p{25} . $p{24} . $p{12} . $p{10} . $p{3} . $p{30} . $p{16} . $p{8} . $p{29} . $p{21} . $p{27} . $p{1} . $p{26} . $p{22} . $p{7} . $p{19} . $p{2};
        return $q;
    }

    protected function unregisterUserEntity($user)
    {
        $response = [];
        $response['success'] = true;
        $response['msg'] = '';

        $auth =  Yii::$app->authManager;
        $currentRole = $auth->getRole($user->getRole());
        $entity = null;

        try
        {
            switch($currentRole->name){
                case 'Importador':
                case 'Exportador':
                case "Importador_Exportador":
                case AuthItem::ROLE_SPECIAL_IMPORTER_EXPORTER:
                case 'Agencia':
                    $entity = UserAgency::findOne(['user_id'=>$user->id]);
                    break;
                case 'Administrador_deposito':
                case 'Deposito':
                    $entity = UserWarehouse::findOne(['user_id'=>$user->id]);
                    break;
                case 'Cia_transporte':
                    $entity = UserTranscompany::findOne(['user_id'=>$user->id]);
                    break;
                default :
                    break;
            }

            if($entity)
            {
                $entity->delete();
            }
        }
        catch (Exception $ex)
        {
            $response['success'] = false;
        }

        if(!$response['success'])
        {
            $response['msg'] = 'Ah ocurrido un error al actualizar los datos de la empresa asociada al usuario.';
        }

        return $response;
    }

    protected function registerUserEntity($user, $entityData, $roleName)
    {
        $response = [];
        $response['success'] = true;
        $response['msg'] = '';
        try
        {
           switch ($roleName)
           {
               case 'IMPORTADOR_EXPORTADOR':
               case 'IMPORTADOR_EXPORTADOR_ESPECIAL':
                   $agency = Agency::findOne(['ruc'=>$entityData['ruc_empresa']]);
                   if($agency == null)
                   {
                       $agency = new Agency();
                       $agency->name = $entityData['nombre_empresa'];
                       $agency->ruc = $entityData['ruc_empresa'];
                       $agency->code_oce = '';
                       $agency->active = 1;

                       $response['success'] = $agency->save();
                   }

                   if($response['success'])
                   {
                       $user_agency = new UserAgency();
                       $user_agency->user_id = $user->id;
                       $user_agency->agency_id = $agency->id;

                       $response['success'] = $user_agency->save();
                   }
                   break;
               case 'CIA_TRANSPORTE':
                   $transCompany = TransCompany::findOne(['ruc'=>$entityData['ruc_empresa']]);
                   if($transCompany == null)
                   {
                       $transCompany = new TransCompany();
                       $transCompany->name = $entityData['nombre_empresa'];
                       $transCompany->ruc = $entityData['ruc_empresa'];
                       $transCompany->address = 'NO TIENE';
                       $transCompany->active = 1;

                       $response['success'] = $transCompany->save();
//                       $response['msg'] = implode('', $transCompany->getErrorSummary(false));
                   }

                   if($response['success'])
                   {
                       $user_trans = new UserTranscompany();
                       $user_trans->user_id = $user->id;
                       $user_trans->transcompany_id = $transCompany->id;

                       $response['success'] = $user_trans->save();
//                       $response['msg'] = implode('', $user_trans->getErrorSummary(false));
                   }

                   break;
               case 'ADMINISTRADOR_DEPOSITO':
               case 'DEPOSITO':
                   $wharehouse = Warehouse::findOne(['id'=>1]);
                   if($wharehouse == null)
                   {
                       $wharehouse = new Warehouse();
                       $wharehouse->name = $entityData['nombre_empresa'];
                       $wharehouse->ruc = $entityData['ruc_empresa'];
                       $wharehouse->code_oce = '';
                       $wharehouse->active = 1;

                       $response['success'] = $wharehouse->save();
                   }

                   if($response['success'])
                   {
                       $user_wharehouse = new UserWarehouse();
                       $user_wharehouse->user_id = $user->id;
                       $user_wharehouse->warehouse_id = $wharehouse->id;

                       $response['success'] = $user_wharehouse->save();
                   }

                   break;
               default:
                   break;
           }
        }
        catch (Exception $ex)
        {
           $response['success'] = false;
        }

        if(!$response['success'])
        {
            $response['msg'] = 'Ah ocurrido un error al actualizar la empresa asociada al usuario.';
        }

        return $response;
    }
}