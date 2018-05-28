<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property string $code_oce
 * @property string $name
 * @property int $active
 * @property string $ruc
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code_oce', 'name', 'ruc'], 'required'],
            [['code_oce', 'name', 'ruc'], 'string'],
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
            'code_oce' => 'Code Oce',
            'name' => 'Name',
            'active' => 'Active',
            'ruc' => 'Ruc',
        ];
    }
}
