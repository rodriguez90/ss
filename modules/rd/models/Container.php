<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "container".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $tonnage
 * @property int $active
 * @property string $status
 *
 * @property ProcessTransaction[] $processTransactions
 */
class Container extends \yii\db\ActiveRecord
{
    const DRY = 'DRY';
    const RRF  = 'RRF';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'container';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'tonnage', 'status'], 'required'],
            [['name', 'code', 'status'], 'string'],
            [['tonnage', 'active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Número',
            'name' => 'Contenedor',
            'code' => 'Código',
            'tonnage' => 'Toneladas',
            'active' => 'Activo',
            'status' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTransactions()
    {
        return $this->hasMany(ProcessTransaction::class, ['container_id' => 'id']);
    }
}
