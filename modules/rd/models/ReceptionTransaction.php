<?php

namespace app\modules\rd\models;

use Yii;

/**
 * This is the model class for table "reception_transaction".
 *
 * @property int $id
 * @property string $reception_id
 * @property int $container_id
 * @property string $regiter_truck
 * @property string $register_driver
 * @property string $delivery_date
 * @property int $active
 *
 * @property Container $container
 * @property Reception $reception
 * @property Ticket[] $tickets
 */
class ReceptionTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reception_id', 'container_id', 'delivery_date', 'active'], 'required'],
            [['reception_id', 'container_id', 'active'], 'integer'],
            [['regiter_truck', 'register_driver'], 'string'],
            [['delivery_date'], 'safe'],
            [['container_id'], 'exist', 'skipOnError' => true, 'targetClass' => Container::className(), 'targetAttribute' => ['container_id' => 'id']],
            [['reception_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reception::className(), 'targetAttribute' => ['reception_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reception_id' => Yii::t('app', 'Reception ID'),
            'container_id' => Yii::t('app', 'Container ID'),
            'regiter_truck' => Yii::t('app', 'Regiter Truck'),
            'register_driver' => Yii::t('app', 'Register Driver'),
            'delivery_date' => Yii::t('app', 'Delivery Date'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContainer()
    {
        return $this->hasOne(Container::className(), ['id' => 'container_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReception()
    {
        return $this->hasOne(Reception::className(), ['id' => 'reception_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['reception_transaction_id' => 'id']);
    }
}
