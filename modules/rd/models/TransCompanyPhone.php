<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "trans_company_phone".
 *
 * @property int $id
 * @property resource $phone_number
 * @property int $trans_company_id
 *
 * @property TransCompany $transCompany
 */
class TransCompanyPhone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_company_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number', 'trans_company_id'], 'required'],
            [['phone_number'], 'string'],
            [['trans_company_id'], 'integer'],
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
            'phone_number' => 'Phone Number',
            'trans_company_id' => 'Trans Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCompany()
    {
        return $this->hasOne(TransCompany::className(), ['id' => 'trans_company_id']);
    }
}
