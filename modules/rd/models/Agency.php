<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "agency".
 *
 * @property int $id
 * @property string $name
 * @property string $code_oce
 * @property string $ruc
 * @property int $active
 */
class Agency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code_oce', 'ruc', 'active'], 'required'],
            [['name', 'code_oce', 'ruc'], 'string'],
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
            'code_oce' => 'Código Oce',
            'ruc' => 'RUC',
            'active' => 'Activa',
        ];
    }
}
