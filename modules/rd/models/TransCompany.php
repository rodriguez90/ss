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
            [['name', 'ruc', 'address'], 'required'],
            [['name', 'ruc', 'address'], 'string'],
            [['active'], 'integer'],
        ];
    }

    public function attributes()
    {
        $attr = parent::attributes();
        $attr[] = 'phones';
        return $attr;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'ruc' => 'RUC',
            'address' => 'Dirección',
            'active' => 'Activa',
            'phones' => 'Teléfonos',
        ];
    }

    public function getPhones()
    {
        return $this->hasMany(TransCompanyPhone::className(), ['trans_company_id' => 'id']);
    }

}
