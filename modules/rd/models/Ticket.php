<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $delivery_date
 * @property int $reception_transaction_id
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
            [['delivery_date', 'reception_transaction_id', 'active'], 'required'],
            [['delivery_date'], 'safe'],
            [['reception_transaction_id', 'active'], 'integer'],
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
            'delivery_date' => Yii::t('app', 'Delivery Date'),
            'reception_transaction_id' => Yii::t('app', 'Reception Transaction ID'),
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
