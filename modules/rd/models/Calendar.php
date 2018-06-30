<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property int $id
 * @property int $id_warehouse
 * @property string $start_datetime
 * @property string $end_datetime
 * @property int $amount
 *
 * @property Warehouse $warehouse
 * @property Ticket[] $tickets
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_warehouse', 'start_datetime', 'end_datetime', 'amount'], 'required'],
            [['id_warehouse', 'amount'], 'integer'],
            [['start_datetime', 'end_datetime'], 'safe'],
            [['id_warehouse'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['id_warehouse' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_warehouse' => Yii::t('app', 'Depósito'),
            'start_datetime' => Yii::t('app', 'Fecha Inicio'),
            'end_datetime' => Yii::t('app', 'Fecha Fin'),
            'amount' => Yii::t('app', 'Cantidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'id_warehouse']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['calendar_id' => 'id']);
    }
}
