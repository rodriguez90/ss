<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "trans_company_phone".
 *
 * @property int $id
 * @property string $number
 * @property int $trans_company_id
 *
 * @property TransCompany $id0
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
            [['number', 'trans_company_id'], 'required'],
            [['trans_company_id'], 'integer'],
            [['number'], 'string', 'max' => 12],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TransCompany::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'trans_company_id' => 'Trans Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(TransCompany::className(), ['id' => 'id']);
    }
}
