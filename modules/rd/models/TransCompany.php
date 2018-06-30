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
        ];
    }
}
