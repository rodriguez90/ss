<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "line".
 *
 * @property int $id Número
 * @property string $name Nombre
 * @property string $code Código
 * @property string $oce Oce
 * @property int $active Activa
 *
 * @property Process[] $processes
 */
class Line extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'oce'], 'required'],
            [['name', 'code', 'oce'], 'string'],
            [['active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Número',
            'name' => 'Nombre',
            'code' => 'Código',
            'oce' => 'Oce',
            'active' => 'Activa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesses()
    {
        return $this->hasMany(Process::className(), ['line_id' => 'id']);
    }
}
