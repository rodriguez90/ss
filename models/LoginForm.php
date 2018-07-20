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

//            $customPassword = $this->makeTPGPassword($this->password);

        $response = $this->tpgLogin($this->username, $this->password); // FIXME en produccion pasar el $customPassword
        return $response;
//            var_dump($response);die;

//            user_id,nombre,ruc,email,ruc_empresa,nombre_empresa,rol,estado
//            '0391014531001','JUAN CHIMBO','0301010252','papa.felipe@hotmail.com','0391014531001','COMPAÃ\x91IA DE TRANSPORTE PESADO Y COMBUSTIBLE TROREC','CIA_TRANSPORTE','ACTIVO'

        if(!$response['sucess'])
        {
            $this->addError('error', 'Ah ocurrido un error al realizar la autenticación con TPG.');
            return false;
        }
        elseif ($response['user'] == null)
        {
            $this->addError('error', 'Usuario ó Contraseña Incorrecta.');
            return false;
        }
        elseif ($response['user'] !== null && $response['user']['estado'] !== 'ACTIVO' )
        {
            $this->addError('error', 'El usuario esta inactivo, consulte al administrador.');
            return false;
        }

        $sgtUser = AdmUser::findOne(['username'=>$this->username]); // find user in sgt

        if($sgtUser == null)
        {
            $newUser = new AdmUser();
            $newUser->username = $response['user']['user_id'];
            $newUser->nombre = $response['user']['nombre'];
            $newUser->apellidos = '';
            $newUser->cedula = $response['user']['ruc'];
            $newUser->email = $response['user']['email'];
            $newUser->status = $response['user']['estado'] == 'ACTIVO' ? 1:0;
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
                $roleName = $response['user']['rol'];
                switch ($roleName)
                {
                    case 'IMPORTADOR_EXPORTADOR':
                        $agency = Agency::findOne(['ruc'=>$response['user']['ruc_empresa']]);
                        if($agency == null)
                        {
                            $agency = new Agency();
                            $agency->name = $response['user']['nombre_empresa'];
                            $agency->ruc = $response['user']['ruc_empresa'];
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

                        break;
                    case 'CIA_TRANSPORTE':
                        $transCompany = TransCompany::findOne(['ruc'=>$response['user']['ruc_empresa']]);
                        if($transCompany == null)
                        {
                            $transCompany = new TransCompany();
                            $transCompany->name = $response['user']['nombre_empresa'];
                            $transCompany->ruc = $response['user']['ruc_empresa'];
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

                        break;
                    case 'ADMINISTRADOR_DEPOSITO': // FIXME CHECK THIS
                        $wharehouse = Warehouse::findOne(['name'=>$response['user']['nombre_empresa']]);
                        if($wharehouse == null)
                        {
                            $wharehouse = new Warehouse();
                            $wharehouse->name = $response['user']['nombre_empresa'];
                            $wharehouse->ruc = $response['user']['ruc_empresa'];
                            $wharehouse->code_oce = $response['user']['ruc_empresa'];
                            $wharehouse->active = 1;

                            $ok = $wharehouse->save();
                        }

                        if($ok)
                        {
                            $user_wharehouse = new UserWarehouse();
                            $user_wharehouse->user_id = $newUser->id;
                            $user_wharehouse->transcompany_id = $wharehouse->id;

                            $ok = $user_wharehouse->save();
                        }

                        break;
                    default:
                        break;
                }

                if($ok)
                {
                    $new_rol = $auth->createRole($roleName);
                    $ok = $ok && $auth->assign($new_rol, $newUser->id);
                }

                if(!$ok)
                {
                    $msg = "Ah ocurrido un error al registrar el usuario.";
                    $this->addError('error', $msg);
                    return false;
                }
            }
        }

        return Yii::$app->user->login($this->getUser(), $this->rememberMe == 'on' ? 3600 * 24 * 30 : 0);

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
                $result['nombre'] = utf8_decode($result['nombre']);
                $result['nombre_empresa'] = utf8_decode($result['nombre_empresa']);
                $response['user'] = $result;
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
