<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int process_transaction_id
 * @property int $calendar_id
 * @property int $status
 * @property string $created_at
 * @property int $active
 * @property int $acc_id
 *
 * @property ReceptionTransaction $receptionTransaction
 */
class Ticket extends \yii\db\ActiveRecord
{

    const PRE_BOOKING = 0;
    const RESERVE  = 1;

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
            [['process_transaction_id', 'calendar_id', 'status', 'active'], 'required'],
            [['process_transaction_id', 'calendar_id', 'status', 'active', 'acc_id'], 'integer'],
            [['created_at'], 'safe'],
            [['process_transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessTransaction::className(), 'targetAttribute' => ['process_transaction_id' => 'id']],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Número'),
            'process_transaction_id' => Yii::t('app', 'Contenedor'),
            'calendar_id' => Yii::t('app', 'Fecha'),
            'status' => Yii::t('app', 'Estado'),
            'created_at' => Yii::t('app', 'Fecha de Creación'),
            'active' => Yii::t('app', 'Activo'),
            'acc_id' => Yii::t('app', 'Acceso'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessTransaction()
    {
        return $this->hasOne(ProcessTransaction::className(), ['id' => 'process_transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
//        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id', 'active'=>1]);
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }
}
