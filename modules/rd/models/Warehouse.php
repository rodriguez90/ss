<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property string $name
 * @property string $code_oce
 * @property int $active
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
            [['name', 'code_oce', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['code_oce'], 'string', 'max' => 10],
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
            'code_oce' => 'Código Oce',
            'active' => 'Activo',
        ];
    }
}
