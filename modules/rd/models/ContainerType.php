<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "container_type".
 *
 * @property int $id Número
 * @property string $code Código
 * @property int $tonnage Toneladas
 * @property int $active Activo
 * @property string $name Nombre
 *
 * @property Container[] $containers
 */
class ContainerType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'container_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'tonnage', 'active', 'name'], 'required'],
            [['id', 'tonnage', 'active'], 'integer'],
            [['code', 'name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Número',
            'code' => 'Código',
            'tonnage' => 'Toneladas',
            'active' => 'Activo',
            'name' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContainers()
    {
        return $this->hasMany(Container::className(), ['type_id' => 'id']);
    }
}
