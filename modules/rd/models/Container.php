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
            [['name', 'code', 'tonnage'], 'required'],
            [['name', 'code'], 'string'],
            [['tonnage', 'active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'tonnage' => 'Tonnage',
            'active' => 'Active',
        ];
    }
}
