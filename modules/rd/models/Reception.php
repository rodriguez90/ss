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
            [['agency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agency::className(), 'targetAttribute' => ['agency_id' => 'id']],
            [['trans_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransCompany::className(), 'targetAttribute' => ['trans_company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bl' => 'Bl',
            'trans_company_id' => 'Trans Company ID',
            'agency_id' => 'Agency ID',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCompany()
    {
        return $this->hasOne(TransCompany::className(), ['id' => 'trans_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionTransactions()
    {
        return $this->hasMany(ReceptionTransaction::className(), ['reception_id' => 'id']);
    }
}
