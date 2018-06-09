<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "reception".
 *
 * @property string $id
 * @property string $bl
 * @property int $trans_company_id
 * @property int $agency_id
 * @property int $active
 * @property string $created_at
 *
 * @property Agency $agency
 * @property TransCompany $transCompany
 * @property ReceptionTransaction[] $receptionTransactions
 */
class Reception extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bl', 'trans_company_id', 'agency_id', 'active'], 'required'],
            [['bl'], 'string'],
            [['trans_company_id', 'agency_id', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['agency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agency::class(), 'targetAttribute' => ['agency_id' => 'id']],
            [['trans_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransCompany::class, 'targetAttribute' => ['trans_company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bl' => Yii::t('app', 'Código BL'),
            'trans_company_id' => Yii::t('app', 'Cia de Transporte'),
            'transCompany' => Yii::t('app', 'Cia de Transporte'),
            'agency_id' => Yii::t('app', 'Agencia'),
            'agency' => Yii::t('app', 'Agencia'),
            'active' => Yii::t('app', 'Activa'),
            'created_at' => Yii::t('app', 'Fecha de Envío'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::class, ['id' => 'agency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCompany()
    {
        return $this->hasOne(TransCompany::class, ['id' => 'trans_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionTransactions()
    {
        return $this->hasMany(ReceptionTransaction::class, ['reception_id' => 'id']);
    }

    public function getContainerAmount()
    {
//        return $this->hasMany(ReceptionTransaction::className(), ['reception_id' => 'id'])->count();
        return $this->getReceptionTransactions()->count();
    }
}
