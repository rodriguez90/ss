<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "trans_company".
 *
 * @property int $id
 * @property string $name
 * @property string $ruc
 * @property string $address
 * @property int $active
 *
 * @property TransCompanyPhone $transCompanyPhone
 */
class TransCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'ruc', 'address', 'active'], 'required'],
            [['address'], 'string'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['ruc'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'ruc' => 'Ruc',
            'address' => 'Dirección',
            'active' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransCompanyPhone()
    {
        return $this->hasOne(TransCompanyPhone::className(), ['id' => 'id']);
    }
}
