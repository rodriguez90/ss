<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "container".
 *
 * @property int $id
 * @property string $code
 * @property int $tonnage
 * @property int $active
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
            [['code', 'tonnage', 'active'], 'required'],
            [['tonnage', 'active'], 'integer'],
            [['code'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'tonnage' => 'Tonnage',
            'active' => 'Active',
        ];
    }
}
