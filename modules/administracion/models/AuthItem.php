<?php

namespace app\modules\administracion\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property User[] $users
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $parents
 * @property AuthItem[] $children
 */
class AuthItem extends \yii\db\ActiveRecord
{

//    const ROLE_ADMIN = 'Administrador';
    const ROLE_ADMIN = 'Administracion';
    const ROLE_ADMIN_WHAREHOUSE = 'Administrador_depósito';
    const ROLE_WHAREHOUSE = 'Depósito';
    const ROLE_AGENCY = 'Agencia';
    const ROLE_CIA_TRANS_COMPANY = 'Cia_transporte';
    const ROLE_IMPORTER = 'Importador';
    const ROLE_EXPORTER = 'Exportador';
    const ROLE_IMPORTER_EXPORTER = 'Importador_Exportador';

    const ROL_LABEL = [ROL_ADMIN=>'Administrador',
        ROL_ADMIN_WHAREHOUSE=>'Administrador de Depósito',
        ROLE_WHAREHOUSE=>'Depósito',
        ROL_AGENCY=>'Agencia',
        ROLE_TRANS_COMPANY=>'Cia de Transporte',
        ROLE_IMPORTER=>'Importador',
        ROLE_EXPORTER=>'Exportador',
        ROLE_IMPORTER_EXPORTER=>'Importador-Exportador',

    ];

    const DEFAULT_ROLES = [ROLE_ADMIN, ROLE_ADMIN_WHAREHOUSE,
                           ROLE_WHAREHOUSE, ROLE_AGENCY,
                           ROLE_CIA_TRANS_COMPANY,
                           ROLE_IMPORTER,
                           ROLE_EXPORTER,
                           ROLE_IMPORTER_EXPORTER];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('auth_assignment', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }
}
