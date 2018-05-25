<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "agency".
 *
 * @property int $id
 * @property string $name
 * @property string $code
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
            [['name', 'code', 'active'], 'required'],
            [['active'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 10],
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
            'active' => 'Active',
        ];
    }
}
