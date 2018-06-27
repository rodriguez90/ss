<?php

namespace app\modules\rd\models;

use app\modules\administracion\models\AdmUser;
use Yii;

/**
 * This is the model class for table "user_transcompany".
 *
 * @property int $id
 * @property int $user_id
 * @property int $transcompany_id
 *
 * @property AdmUser $user
 * @property TransCompany $transcompany
 */
class UserTranscompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_transcompany';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'transcompany_id'], 'required'],
            [['user_id', 'transcompany_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdmUser::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['transcompany_id'], 'exist', 'skipOnError' => true, 'targetClass' => TransCompany::className(), 'targetAttribute' => ['transcompany_id' => 'id']],
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
            'transcompany_id' => Yii::t('app', 'Transcompany ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AdmUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranscompany()
    {
        return $this->hasOne(TransCompany::className(), ['id' => 'transcompany_id']);
    }
}
