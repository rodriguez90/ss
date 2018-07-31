<?php
namespace app\modules\administracion\models;

use app\modules\rd\models\UserTranscompany;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "adm_user".
 *
 * @property integer $id
 * @property string  $username
 * @property string  $auth_key
 * @property string  $password
 * @property string  $email
 * @property string  $cedula
 * @property string  $nombre
 * @property string  $apellidos
 * @property string  $creado_por
 * @property integer $status
 * @property string  $created_at
 * @property string  $updated_at
 */
class AdmUser extends ActiveRecord implements IdentityInterface
{

    /**
     * @var string Usada para identificar la cookie
     */
    public $authKey = 'SGT_cookiesX2018';
    /**
     * @var string Usado para confirmar el password
     */
    public $passwordConfirm;

    /**
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string $passwordConfirm
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adm_user';
    }

    /**
     * @return array
     * metodo que redefine los escenarios para garantizar que se
     * validen los atributos segun el escenario en el que se encuentre
     */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        /*
        return [
            [['username', 'password', 'email'], 'required'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['username', 'password', 'authKey', 'email', 'nombre', 'apellidos'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
        */
        return [
            [['username', 'password', 'email', 'nombre', 'status', 'cedula'], 'required'],
            [['username', 'auth_key', 'password', 'email','cedula', 'nombre', 'apellidos', 'creado_por', 'password_reset_token'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer']


        ];

    }

    /**
     * @return array
     * usado para sobrescribir el metodo padre y añadir el atributo passwordConfirm
     */
    public function attributes()
    {
        $attr = parent::attributes();
        $attr[] = 'passwordConfirm';
		$attr[] = 'item_name';
        return $attr;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'auth_key' => 'Auth Key',
            'password' => 'Contraseña',
            'cedula' => 'Cedula',
            //            'passwordConfirm' => 'Confirmar contaseña',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'cedula' => 'Cédula',
            'creado_por' => 'Creador',
            'status' => 'Estado',
            'created_at' => 'Creado',
            'updated_at' => 'Modificado',
            'passwordConfirm' => 'Confirmar Contraseña',
			'item_name'=>'Rol'
        ];
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     *
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }


    /**
     * @inheritdoc
     * @return AdmUserQuery the active query used by this AR class.
     */


    /**
     * Finds user by username
     *
     * @param  string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        try {
            return static::findOne(['username' => $username]);
        } catch (Exception $e) {
            die("Error en el acceso a la base de datos.<br/>");
        }
    }

    /**
     * @param $
     * @param $mail
     *
     * @return null|static
     */
    public static function findByEmail($mail)
    {
        return static::findOne(['email' => $mail, 'status' => 1]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }


    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne(['password_reset_token' => $token, 'status' => 1,]);
    }

    /**
     * @param $token
     *
     * @return null|static
     */
    public static function findByPasswordResetTokenUseRegister($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne(['password_reset_token' => $token, 'status' => 0,]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /* todo implementar funcionalidad findIdentityByAccessToken*/
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    public function getNombreByID($id)
    {
        return $this->findOne($id);
    }


    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

	public function hasRol($rol)
    {
//        $rols =  Yii::$app->authManager->getRolesByUser($this->username);


        $result = AdmUser::find()
            ->innerJoin("auth_assignment","auth_assignment.user_id = adm_user.id")
            ->where(['auth_assignment.item_name'=>$rol, 'auth_assignment.user_id' =>$this->id])
            ->count();


//        $count = $this->hasMany(AuthAssignment::class, ['user_id' => 'id', 'item_name'=>$rol])->count();
//        var_dump($result); die();
        return $result > 0;
    }

    public function getRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (!$roles) {
            return null;
        }

        return array_shift($roles)->name;
    }

    public function getTransCompany()
    {
        $userTransCompany = UserTranscompany::findOne(['user_id'=>$this->id]);

        if($userTransCompany)
            return $userTransCompany->transcompany;

        return null;
    }

    public function getAgency()
    {
        $userAgency = \app\modules\rd\models\UserAgency::findOne(['user_id'=>$this->id]);

        if($userAgency)
            return $userAgency->agency;

        return null;
    }

    public function getWhareHouse()
    {
        $userWhareHouse = \app\modules\rd\models\UserWarehouse::findOne(['user_id'=>$this->id]);

        if($userWhareHouse)
            return $userWhareHouse->warehouse;

        return null;
    }

    public function processCondition()
    {
        if($this->hasRol('Importador_Exportador'))
        {
            $agency = $this->getAgency();
            $params['agency_id'] = '';
            if($agency)
            {
                $params['agency_id'] = $agency->id;
            }
        }
        else if ($this->hasRol('Cia_transporte'))
        {
            $transcompany = $this->getTransCompany();
            $params['trans_company_id'] = '';
            if($transcompany)
            {
                $params['trans_company_id'] = $transcompany->id;
            }
        }
//        else if ($this->hasRol('Deposito') || $this->hasRol('Administrador_deposito'))
//        {
//            $wareHouse = $this->getWhareHouse();
//            $params['id_warehouse'] = '';
//            if($wareHouse)
//            {
//                $params['id_warehouse'] = $wareHouse->id;
//            }
//        }

        return $params;
    }

    public function asociatedEntity()
    {
        $entity = null;
        if($this->hasRol('Importador_Exportador'))
        {
            $entity = $this->getAgency();
        }
        else if ($this->hasRol('Cia_transporte')){
            $entity = $this->getTransCompany();
        }
        else if($this->hasRol('Administracion'))
        {
            $entity =  true;
        }

        return $entity;
    }
}
