<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "container".
 *
 * @property int $id Número
 * @property string $name Nombre
 * @property string $code Código
 * @property int $tonnage Toneladas
 * @property int $active Activo
 * @property string $status Estado
 * @property int $type_id Tipo
 *
 * @property ContainerType $type
 * @property ProcessTransaction[] $processTransactions
 */
class Container extends \yii\db\ActiveRecord
{
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
            [['tonnage', 'active', 'type_id'], 'integer'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContainerType::className(), 'targetAttribute' => ['type_id' => 'id']],
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
            'tonnage' => 'Toneladas',
            'active' => 'Activo',
            'status' => 'Estado',
            'type_id' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ContainerType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTransactions()
    {
        return $this->hasMany(ProcessTransaction::className(), ['container_id' => 'id']);
    }
}
