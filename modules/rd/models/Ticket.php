<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int $reception_transaction_id
 * @property int $calendar_id
 * @property int $status
 * @property string $created_at
 * @property int $active
 *
 * @property ReceptionTransaction $receptionTransaction
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reception_transaction_id', 'calendar_id', 'status', 'active'], 'required'],
            [['reception_transaction_id', 'calendar_id', 'status', 'active'], 'integer'],
            [['created_at'], 'safe'],
            [['reception_transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReceptionTransaction::className(), 'targetAttribute' => ['reception_transaction_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reception_transaction_id' => Yii::t('app', 'Reception Transaction ID'),
            'calendar_id' => Yii::t('app', 'Calendar ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionTransaction()
    {
        return $this->hasOne(ReceptionTransaction::className(), ['id' => 'reception_transaction_id']);
    }
}
