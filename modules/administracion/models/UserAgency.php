<?php

namespace app\modules\administracion\models;

use Yii;

/**
 * This is the model class for table "user_agency".
 *
 * @property int $id
 * @property int $user_id
 * @property int $agency_id
 *
 * @property Agency $agency
 * @property AdmUser $user
 */
class UserAgency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_agency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'agency_id'], 'required'],
            [['user_id', 'agency_id'], 'integer'],
            [['agency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Agency::className(), 'targetAttribute' => ['agency_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdmUser::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'agency_id' => 'Agency ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AdmUser::className(), ['id' => 'user_id']);
    }
}
