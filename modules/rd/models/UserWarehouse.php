<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "user_warehouse".
 *
 * @property int $id
 * @property int $user_id
 * @property int $warehouse_id
 *
 * @property Warehouse $warehouse
 * @property AdmUser $user
 */
class UserWarehouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_warehouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'warehouse_id'], 'required'],
            [[ 'user_id', 'warehouse_id'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'warehouse_id' => Yii::t('app', 'Warehouse ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AdmUser::className(), ['id' => 'user_id']);
    }
}
