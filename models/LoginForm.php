<?php

namespace app\models;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Agency;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;
use app\modules\rd\models\UserWarehouse;
use app\modules\rd\models\Warehouse;
use Yii;
use yii\base\Model;

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

		$userData = $response['user'];

        if(!$response['success'])
        {
            $this->addError('error', 'Ah ocurrido un error al realizar la autenticación con TPG.');
            return false;
        }
        elseif ($userData == null)
        {
            $this->addError('error', 'Usuario ó Contraseña Incorrecta.');
            return false;
        }
        elseif ($userData !== null && $userData['estado'] !== "ACTIVO")
        {
            $this->addError('error', 'El usuario esta inactivo, consulte al administrador.');
            return false;
        }

        $newUser = AdmUser::findOne(['username'=>$this->username]); // find user in sgt

        if($newUser == null)
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

            $auth =  Yii::$app->authManager;
            $new_rol = null;
            $ok = true;
            $msg = '';

            if ($newUser->save())
            {
                $roleName = $userData['rol'];
                $rol = '';
                switch ($roleName)
                {
                    case 'IMPORTADOR_EXPORTADOR':
                        $agency = Agency::findOne(['ruc'=>$userData['ruc_empresa']]);
                        if($agency == null)
                        {
                            $agency = new Agency();
                            $agency->name = $userData['nombre_empresa'];
                            $agency->ruc = $userData['ruc_empresa'];
                            $agency->code_oce = '';
                            $agency->active = 1;

                            $ok = $agency->save();
                        }

                        if($ok)
                        {
                            $user_agency = new UserAgency();
                            $user_agency->user_id = $newUser->id;
                            $user_agency->agency_id = $agency->id;

                            $ok = $user_agency->save();
                        }
                        $rol = 'Importador_Exportador';
                        break;
                    case 'CIA_TRANSPORTE':
                        $transCompany = TransCompany::findOne(['ruc'=>$userData['ruc_empresa']]);
                        if($transCompany == null)
                        {
                            $transCompany = new TransCompany();
                            $transCompany->name = $userData['nombre_empresa'];
                            $transCompany->ruc = $userData['ruc_empresa'];
                            $transCompany->address = 'NO TIENE';
                            $transCompany->active = 1;

                            $ok = $transCompany->save();
                        }

                        if($ok)
                        {
                            $user_trans = new UserTranscompany();
                            $user_trans->user_id = $newUser->id;
                            $user_trans->transcompany_id = $transCompany->id;

                            $ok = $user_trans->save();
                        }
                        $rol = 'Cia_transporte';

                        break;
                    case 'ADMINISTRADOR_DEPOSITO': // FIXME CHECK THIS
                        $wharehouse = Warehouse::findOne(['id'=>1]);
                        if($wharehouse == null)
                        {
                            $wharehouse = new Warehouse();
                            $wharehouse->name = $userData['nombre_empresa'];
                            $wharehouse->ruc = $userData['ruc_empresa'];
                            $wharehouse->code_oce = $userData['ruc_empresa'];
                            $wharehouse->active = 1;

                            $ok = $wharehouse->save();
                        }

                        if($ok)
                        {
                            $user_wharehouse = new UserWarehouse();
                            $user_wharehouse->user_id = $newUser->id;
                            $user_wharehouse->warehouse_id = $wharehouse->id;

                            $ok = $user_wharehouse->save();
                        }
                        $rol = 'Administrador_deposito';

                        break;
                    case 'DEPOSITO': // FIXME CHECK THIS
                        $wharehouse = Warehouse::findOne(['id'=>1]);
                        if($wharehouse == null)
                        {
                            $wharehouse = new Warehouse();
                            $wharehouse->name = $userData['nombre_empresa'];
                            $wharehouse->ruc = $userData['ruc_empresa'];
                            $wharehouse->code_oce = $userData['ruc_empresa'];
                            $wharehouse->active = 1;

                            $ok = $wharehouse->save();
                        }

                        if($ok)
                        {
                            $user_wharehouse = new UserWarehouse();
                            $user_wharehouse->user_id = $newUser->id;
                            $user_wharehouse->warehouse_id = $wharehouse->id;

                            $ok = $user_wharehouse->save();
                        }
                        $rol = 'Deposito';

                        break;

                    case 'ADMINISTRADOR': // FIXME CHECK THIS
                        $rol = 'Administracion';

                        break;
                    default:
                        break;
                }

                if($ok)
                {
                    $new_rol = $auth->getRole($rol);
                    $ok = $ok && $auth->assign($new_rol, $newUser->id);
                }

                if(!$ok)
                {
                    $msg = "Ah ocurrido un error al registrar el usuario.";
                    $this->addError('error', $msg);
                    return false;
                }
            }
			else
			{
				 $msg = "Ah ocurrido un error al registrar el usuario.";
				 $this->addError('error', $msg);
				 return false;
			}
        }
        return Yii::$app->user->login($newUser, $this->rememberMe == 'on' ? 1800 : 0);

    }

    public function loginOffLine()
    {
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
            $result = Yii::$app->db3->createCommand($sql)->queryAll();
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
            $response['success'] = false;
            $response['msg'] = 'Ah occurrido un error al realizar el login hacia TPG.';
            $response['msg_dev'] = $ex->getMessage();
        }

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
}
